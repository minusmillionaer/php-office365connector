<?php
/**
 * This file is part of the kernpunkt/office365connector library
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright Copyright (c) Giuliano Schindler <giuliano.schindler@kernpunkt.de>
 * @license https://opensource.org/licenses/gpl-license GNU
 * @link https://kernpunkt.com Website
 */
namespace kernpunkt\OPS;

/**
 * Class Office365Connector
 * @package kernpunkt\OPS
 */
class Office365Connector
{

    private static $_tenantId;
    private static $_clientId;
    private static $_clientSecret;
    private static $_resource;
    private static $_grantType;
    private static $_accessToken;
    private static $_client;

    /**
     * Office365Connector constructor.
     *
     * @param string $_tenantId     Office 365 tenant ID unique identifier (GUID)
     * @param uuid   $_clientId     Microsoft Azure Active Directory App Id
     * @param string $_clientSecret Microsoft Azure Active Directory App Secret
     * @param string $_resource     The App ID URI of the target web API
     * @param string $_grantType    Must be authorization_code for the auth code flow
     */
    public function __construct($_tenantId, $_clientId, $_clientSecret, $_resource, $_grantType)
    {
        self::$_tenantId = $_tenantId;
        self::$_clientId = $_clientId;
        self::$_clientSecret = $_clientSecret;
        self::$_resource = $_resource;
        self::$_grantType = $_grantType;

        self::$_client = new \GuzzleHttp\Client();
        $responseLogin = self::$_client->request('POST',
            'https://login.microsoftonline.com/' . self::$_tenantId . '/oauth2/token', [
                'form_params' => [
                    'client_id' => self::$_clientId,
                    'client_secret' => self::$_clientSecret,
                    'resource' => self::$_resource,
                    'grant_type' => self::$_grantType,
                    ]
            ]);

        self::$_accessToken = json_decode($responseLogin->getBody())->access_token;

    }

    /**
     * Get all groups in this organisation
     *
     * @return object
     */
    public function getGroups(): object
    {
        $responseGraph = self::$_client->request('GET', 'https://graph.microsoft.com/v1.0/groups/', [
            'headers' => [
                'Authorization' => 'Bearer ' . self::$_accessToken,
                'Content-Type' => 'application/x-www-form-urlencoded',
            ],
        ]);

        return json_decode($responseGraph->getBody());

    }

    /**
     * Get all members of this group
     *
     * @param uuid $groupId Azure AD uuid of group
     *
     * @return object
     */
    public function getGroupUsers($groupId): object
    {
        $responseGraph = self::$_client->request('GET',
            'https://graph.microsoft.com/v1.0/groups/' . $groupId . '/members', [
                'headers' => [
                    'Authorization' => 'Bearer ' . self::$_accessToken,
                    'Content-Type' => 'application/x-www-form-urlencoded',
                ],
            ]);

        return json_decode($responseGraph->getBody());
    }

    /**
     * Get all users in this organisation
     *
     * @return object
     */
    public function getUsers(): object
    {
        $responseGraph = self::$_client->request('GET', 'https://graph.microsoft.com/v1.0/users/', [
            'headers' => [
                'Authorization' => 'Bearer ' . self::$_accessToken,
                'Content-Type' => 'application/x-www-form-urlencoded',
            ],
        ]);

        return json_decode($responseGraph->getBody());

    }

    /**
     * Get user details for this user
     *
     * @param uuid $userId Azure AD uuid of User
     *
     * @return object
     */
    public function getUserInfo($userId): object
    {
        $responseGraph = self::$_client->request('GET', 'https://graph.microsoft.com/v1.0/users/' . $userId, [
            'headers' => [
                'Authorization' => 'Bearer ' . self::$_accessToken,
                'Content-Type' => 'application/x-www-form-urlencoded',
            ],
        ]);
        return json_decode($responseGraph->getBody());

    }
}
