<?php

/***
 * This is the controller for the games api
 * This controller handles the CRUD operations for the games api
 * The data is pulled in from https://api-sports.io/documentation/nba/v2
 */

namespace Api\Games;

class Games
{
    private const rapidapi_key = "5d8c6a8982msh23c4018817be5e9p1aeb78jsn8f882a967e98";
    private const rapidapi_host = "api-nba-v1.p.rapidapi.com";

    public $pageSize = 10;

    public $data = [];

    public $id = null;
    public $date = null;
    public $live = null;
    public $league = null;
    public $season = null;
    public $team = null;
    public $h2h = null;


    public function __construct(
        $id = null,
        $date = null,
        $live = null,
        $league = null,
        $season = null,
        $team = null,
        $h2h = null
    ) {
        $this->id = $id;
        $this->date = $date;
        $this->live = $live;
        $this->league = $league;
        $this->season = $season;
        $this->team = $team;
        $this->h2h = $h2h;


        // check if any argument is not null
        if (
            $this->id !== null ||
            $this->date !== null ||
            $this->live !== null ||
            $this->league !== null ||
            $this->season !== null ||
            $this->team !== null ||
            $this->h2h !== null
        ) {

            $this->data = $this->getGames();
        }
    }

    /**
     * Get all games
     * @return array|bool
     * @throws \Exception
     */
    public function getGames()
    {
        $queries = [
            'id' => $this->id,
            'date' => $this->date,
            'live' => $this->live,
            'league' => $this->league,
            'season' => $this->season,
            'team' => $this->team,
            'h2h' => $this->h2h
        ];

        foreach ($queries as $key => $value) {
            if ($value === null || $value === '' || empty($value)) {
                unset($queries[$key]);
            }
        }

        if (empty($queries)) {
            $this->data = new \Error('No queries were provided', 400);
            return false;
        }

        $response = false;
        try {

            $curl = curl_init();

            // Check if initialization had gone wrong
            if ($curl === false) {
                throw new \Exception('Curl failed to initialize!');
            }

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api-nba-v1.p.rapidapi.com/games?' . http_build_query($queries),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    'x-rapidapi-key: ' . self::rapidapi_key,
                    'x-rapidapi-host: ' . self::rapidapi_host
                ),

                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_SSL_VERIFYPEER => false,
            ));

            $response = curl_exec($curl);

            // Check for server error
            if ($response === false) {
                error_log(curl_error($curl));
                throw new \Exception(curl_error($curl), curl_errno($curl));
            }
        } catch (\Exception $e) {
            $error_message = sprintf(
                'Curl failed with error #%d: %s',
                $e->getCode(),
                $e->getMessage()
            );

            error_log($error_message);
            trigger_error(
                $error_message,
                E_USER_ERROR
            );
        } finally {

            // Check HTTP return code
            $httpReturnCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

            if ($httpReturnCode != 200) {
                error_log('Request failed: HTTP return code: ' . $httpReturnCode . ', response: ' . $response);
                $this->data  = new \Error($response, $httpReturnCode);
                return $this->data;
            }


            // Close curl handle unless it failed to initialize
            if (is_resource($curl)) {
                curl_close($curl);
            }

            $this->data  = json_decode($response);
            return $this->data;
        }
        return false;
    }

    /**
     * Get a pagination of the games
     * @param int $page_number
     * @return array
     * @throws \Exception
     */
    public function getPage($page_number): array
    {
        if (empty($this->data) || !is_object($this->data)) {
            return [];
        }

        if (!is_numeric($page_number)) $page_number = 1;

        $page_number = (int) $page_number;
        $page_number = $page_number < 1 ? 1 : $page_number;

        $offset = ($page_number - 1) * $this->pageSize;

        return [
            'total_count' => $this->data->results,
            'page' => [
                'current' => $page_number,
                'total' => ceil($this->data->results / $this->pageSize)
            ],
            'response' => array_slice($this->data->response, $offset, $this->pageSize)
        ];
    }
}
