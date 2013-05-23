<?php
session_start();
set_include_path(get_include_path() . PATH_SEPARATOR . dirname(__FILE__) . '/../lib/Pintlabs_Service_Untappd/library/');

require_once 'Pintlabs/Service/Untappd.php';


class Backend
{
    /**
     * @var Pintlabs_Service_Untappd
     */
    private $instance = null;

    public function run()
    {
        if (!isset($_SESSION['accessToken']))
        {
            $this->getAccessToken();
        }

        if (!isset($_GET['method']))
        {
            die('Method is missing');
        }
        $method = $_GET['method'];
        switch($method)
        {
            case 'list':

                break;
        }
    }

    private function getFriendFeed()
    {
        try
        {
            $result = $this->getInstance()->myFriendFeed();
        } catch (Pintlabs_Service_Untappd_Exception $e)
        {
            die($e->getMessage());
        }
        var_dump($result->response->checkins);
    }

    private function getAccessToken()
    {
        if (isset($_GET['code']))
        {
            $config = array(
                'clientId'     => 'XXXX',
                'clientSecret' => 'YYYY',
                'redirectUri'  => 'http://alehunt-web-src/haand/backend.php',
            );

            try
            {
                $untappd     = new Pintlabs_Service_Untappd($config);
                $accessToken = $untappd->getAccessToken($_GET['code']);
            } catch (Pintlabs_Service_Untappd_Exception $e)
            {
                die($e->getMessage());
            }

            $_SESSION['accessToken'] = $accessToken;
        }
        else
        {
            $this->redirectToUntappd();
        }
    }

    private function redirectToUntappd()
    {
        header('Location: ' . $this->getInstance()->authenticateUri());
    }

    private function getInstance($accessToken = '')
    {
        if (!$this->instance)
        {
            $config = array(
                'clientId'     => 'XXXX',
                'clientSecret' => 'YYYY',
                'accessToken'  => $accessToken,
                'redirectUri'  => 'http://alehunt-web-src/haand/backend.php',
            );

            $this->instance = new Pintlabs_Service_Untappd($config);
        }

        return $this->instance;
    }
}


$b = new Backend();
$b->run();
