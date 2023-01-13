<?php

namespace Irpcpro\TeleLink\Application\Controllers;

use Irpcpro\TeleLink\Application\Models\Links\Links;

class LinkController extends Controller {

    // create new link
    public function create()
    {
        // get link
        $link = $this->getBody()->link;

        // validate url
        if( checkURL($link) == false ){
            $this->sendOutput([
                'message' => 'invalid URL.',
                'status' => false,
                'data' => [],
            ], 400);
        }

        // generate
        $uuid = generate_uuid();
        $uri = LINK_SHORTENER_PREFIX . '/' . $uuid;
        $newLink = SITE_URL . $uri;

        // insert to database
        $modelLink = new Links();

        // set data
        $currentUserID = $this->current_user()['user_id'];
        $data = [
            'link_original' => $link,
            'suffix' => $uuid,
            'user_id' => $currentUserID,
        ];
        $data = $modelLink->arrayFieldsToText($data);

        // insert to db
        $sql = "INSERT INTO $modelLink->table_name $data";
        $rowID = $modelLink->doQuery($sql);

        // return response
        $this->sendOutput([
            'message' => 'link created.',
            'status' => true,
            'data' => [
                'link_id' => $rowID,
                'link_original' => $link,
                'link_short' => $newLink
            ],
        ]);
    }

    // get all links user
    public function getAll()
    {
        // get current user
        $currentUserID = $this->current_user()['user_id'];

        // get limit
        $limit = htmlspecialchars($_GET['limit']) ?? LIMIT_LIST_SIZE;

        // get all links
        $modelLink = new Links();
        $sql = "SELECT * FROM $modelLink->table_name WHERE deleted = 0 AND user_id = $currentUserID LIMIT $limit";
        $result = $modelLink->select($sql);

        // return response
        $this->sendOutput([
            'message' => 'Data received',
            'status' => true,
            'data' => $result
        ]);
    }

    // delete link
    public function delete($linkID)
    {
        // get id
        $linkID = htmlspecialchars($linkID);
        $currentUserID = $this->current_user()['user_id'];

        // get model
        $modelLinks = new Links();
        $sql = "UPDATE $modelLinks->table_name SET deleted = 1 WHERE link_id = $linkID AND user_id = $currentUserID";
        $modelLinks->doQuery($sql);

        // return result
        $this->sendOutput([
            'message' => 'record deleted.',
            'status' => true,
            'data' => []
        ]);
    }

    // edit original_link
    public function edit()
    {
        // get link
        $linkID = htmlspecialchars($this->getBody()->link_id);
        $link = htmlspecialchars($this->getBody()->link);

        if(!checkURL($link)){
            $this->sendOutput([
                'message' => 'invalid URL.',
                'status' => false,
                'data' => [],
            ], 400);
        }

        // get row
        $currentUserID = $this->current_user()['user_id'];
        $modelLink = new Links();
        $sql = "SELECT * FROM $modelLink->table_name WHERE link_id = $linkID AND user_id = $currentUserID AND deleted = 0";
        $result = $modelLink->select($sql);

        // if row exists
        if(!empty($result)){
            $result = $result[0];
            $newSql = "UPDATE $modelLink->table_name SET link_original = '$link' WHERE link_id = $linkID";
            $modelLink->doQuery($newSql);
            $uri = LINK_SHORTENER_PREFIX . '/' . $result['suffix'];

            $out = [
                "link_id" => 6,
                "link_original" => $link,
                "link_short" => SITE_URL . $uri
            ];

            // return result
            $this->sendOutput([
                'message' => 'record edited.',
                'status' => false,
                'data' => $out
            ]);
        }else{
            $this->sendOutput([
                'message' => 'nothing found.',
                'status' => false,
                'data' => []
            ]);
        }
    }

    // redirect to original_link
    public function redirect($suffix)
    {
        // get suffix
        $suffix = htmlspecialchars($suffix);

        // select url
        $modelLink = new Links();
        $sql = "SELECT * FROM $modelLink->table_name WHERE suffix = '$suffix'";
        $result = $modelLink->select($sql);

        // if row exists
        if(!empty($result)){
            $result = $result[0];
            if($result['link_original']){
                header('Location: '.$result['link_original']);
                exit;
            }
        }

        // return error if suffix is invalid or not found
        echo "<h1>suffix not found</h1>";
        exit;
    }

}

