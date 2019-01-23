<?php

namespace kernpunkt\OPS;

/**
 * Class Office365Connector
 * @package kernpunkt\OPS
 */
class Office365Connector
{

    private static $tenantId;
    private static $clientId;
    private static $clientSecret;
    private static $resource;
    private static $grantType;
    private static $accessToken;
    private static $client;

    /**
     * Office365Connector constructor.
     * @param $tenantId
     * @param $clientId
     * @param $clientSecret
     * @param $resource
     * @param $grantType
     */
    public function __construct($tenantId, $clientId, $clientSecret, $resource, $grantType)
    {
        self::$tenantId = $tenantId;
        self::$clientId = $clientId;
        self::$clientSecret = $clientSecret;
        self::$resource = $resource;
        self::$grantType = $grantType;

        self::$client = new \GuzzleHttp\Client();
        $responseLogin = self::$client->request('POST',
            'https://login.microsoftonline.com/' . self::$tenantId . '/oauth2/token', [
                'form_params' => [
                    'client_id' => self::$clientId,
                    'client_secret' => self::$clientSecret,
                    'resource' => self::$resource,
                    'grant_type' => self::$grantType,
                    ]
            ]);

        self::$accessToken = json_decode($responseLogin->getBody())->access_token;

    }

    /**
     * @return object
     */
    public function getGroups(): object
    {
        $responseGraph = self::$client->request('GET', 'https://graph.microsoft.com/v1.0/groups/', [
            'headers' => [
                'Authorization' => 'Bearer ' . self::$accessToken,
                'Content-Type' => 'application/x-www-form-urlencoded',
            ],
        ]);

        return json_decode($responseGraph->getBody());

    }

    /**
     * @param $groupId
     * @return object
     */
    public function getGroupUsers($groupId): object
    {
        $responseGraph = self::$client->request('GET',
            'https://graph.microsoft.com/v1.0/groups/' . $groupId . '/members', [
                'headers' => [
                    'Authorization' => 'Bearer ' . self::$accessToken,
                    'Content-Type' => 'application/x-www-form-urlencoded',
                ],
            ]);

        return json_decode($responseGraph->getBody());
    }

    /**
     * @return object
     */
    public function getUsers(): object
    {
        $responseGraph = self::$client->request('GET', 'https://graph.microsoft.com/v1.0/users/', [
            'headers' => [
                'Authorization' => 'Bearer ' . self::$accessToken,
                'Content-Type' => 'application/x-www-form-urlencoded',
            ],
        ]);

        return json_decode($responseGraph->getBody());

    }

    /**
     * @param $userId
     * @return object
     */
    public function getUserInfo($userId): object
    {
        $responseGraph = self::$client->request('GET', 'https://graph.microsoft.com/v1.0/users/' . $userId, [
            'headers' => [
                'Authorization' => 'Bearer ' . self::$accessToken,
                'Content-Type' => 'application/x-www-form-urlencoded',
            ],
        ]);
        return json_decode($responseGraph->getBody());

    }
}
