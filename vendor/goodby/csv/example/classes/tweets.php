<?php

/**
 * Class Tweets
 */

class Tweets{
    /**
     * @var int
     */
    private $id;

    /**
     * @var array
     */
    private $tweet_info;

    /**
     * @var string
     */
    private $user;

    /**
     * @var string
     */
    private $tweet;
    /**
     * @var string
     */
    private $tag;
    /**
     * @var string
     */

    /**
     * @var array
     */
    private $tweetlist = array();

    /**
     * @param $dbconnection
     * @param string $id
     */

    /**
     * @var PDO
     */
    private $db;

    /**
     * @param int
     */
    private $lastinsertedid;

    public function __construct($dbconnection, $id = "")
    {

        $this->db = $dbconnection;
        if ($id != "" && is_numeric($id)) {
            $this->read($id);
        }

    }

    public function create()
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO tweets(
                                                           tag)
                                    VALUES(:tag)");
            $stmt->bindParam(":tag", $this->tag);
            $stmt->execute();
            $this->lastinsertedid = $this->db->lastInsertId();

        } catch (PDOException $e) {
            echo "er is iets misgegaan met de verbinding van de server!" . $e->getMessage();
        }
    }

    public function read($id)
    {
        if (empty($id)) {
            throw new InvalidArgumentException('Id is leeg!');
        }
        if (!is_numeric($id)) {
            throw new InvalidArgumentException("Id is geen getal!");
        }

        try {
            $stmt = $this->db->prepare("SELECT id,
                                               user,
                                               tweet,
                                               tag
                                                FROM tweets WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $this->tweet_info = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id = $this->tweet_info['id'];
            $this->user = $this->tweet_info['user'];
            $this->tweet = $this->tweet_info['tweet'];
            $this->tag = $this->tweet_info['tag'];
        } catch (PDOException $e) {
            echo "Database-error: " . $e->getMessage();
        }
    }


    public function update($id)
    {
        if (!is_numeric($id)) {
            throw new InvalidArgumentException('id is geen getal!');
        }
        try {
            $stmt = $this->db->prepare("UPDATE tweets SET id = :uid,
                                                           tag = :utag
                                                           WHERE id= :uid");
            $stmt->bindParam(":uid", $this->id);
            $stmt->bindParam(":utag", $this->tag);

            $stmt->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }


    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getLastInsertedId()
    {
        return $this->lastinsertedid;
    }

    /**
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return string
     */
    public function getTweet()
    {
        return $this->tweet;
    }

    /**
     * @param mixed $tag
     */
    public function setTag($tag)
    {
        $this->tag = htmlentities($tag);
    }

}
?>