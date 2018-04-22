<?php
mb_internal_encoding("UTF-8");

class Db{

  public static $host = 'localhost';
  public static $dbname =  'vue-projekt';
  public static $username = 'root';
  public static $pwd = '';

  public static $pdo;

  public static function init()
  {
    define('SQL_HOST', Db::$host);
    define('SQL_DBNAME', Db::$dbname);
    define('SQL_USERNAME', Db::$username);
    define('SQL_PASSWORD', Db::$pwd);

    $dsn = 'mysql:dbname=' . SQL_DBNAME . ';host=' . SQL_HOST . '';
    $user = SQL_USERNAME;
    $password = SQL_PASSWORD;

    try {
        Db::$pdo = new PDO($dsn, $user, $password);
        Db::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        Db::$pdo->exec("set names utf8");

    } catch (PDOException $e) {
        die('Connection failed: ' . $e->getMessage() );
    }

  }

  public static function SELECT($table)
  {
    $sql= "SELECT * FROM $table";
    $stmt = Db::$pdo->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll();

    return $result;
  }

  function SELECT_URL($table, $url)
  {
    $sql= "SELECT * FROM $table WHERE url = :url";
    $stmt = Db::$pdo->prepare($sql);
    $stmt->execute(array( 'url' => $url ));
    $result = $stmt->fetch();

    return $result;
  }

  function SELECT_N_FILTER($table, $meetupId)
  {
    $sql= "SELECT * FROM $table WHERE meetup_id = '" . $meetupId . "'";
    $stmt = Db::$pdo->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll();

    return $result;
  }

  function SELECT_ID($table, $id)
  {
    $sql= "SELECT * FROM $table WHERE user_id = :user_id";
    $stmt = Db::$pdo->prepare($sql);
    $stmt->execute(array('user_id' => $id));
    $result = $stmt->fetchAll();

    return $result;
  }

  function SELECT_ID_MEETUP($table, $id)
  {
    $sql= "SELECT COUNT(member_id) FROM $table WHERE meetup_id = :meetup_id";
    $stmt = Db::$pdo->prepare($sql);
    $stmt->execute(array( 'meetup_id' => $id ));
    $result = $stmt->fetchColumn();

    return $result;
  }

  function INSERT_TO_USERS($user)
  {
    $password = password_hash($user['password'], PASSWORD_DEFAULT);
    $stmt = Db::$pdo->prepare("INSERT INTO USERS (name, email, password, href) VALUES (:name, :email, :password, :href)");
    $stmt->execute(array(
                    'name' => $user['name'],
                    'email' => $user['email'],
                    'href' => $user['href'],
                    'password' => $password
                    ));

    return Db::$pdo->lastInsertId();
  }

  function GET_USER_BY_EMAIL($user)
  {
    $sql= "SELECT * FROM users WHERE email = :email";
    $stmt = Db::$pdo->prepare($sql);
    $stmt->execute(array( 'email' => $user['email'] ));
    $result = $stmt->fetch();

    $password = $result['password'];

    $verify = password_verify($user['password'], $password);

    if($verify)
    {
      return $result;
    }

    return;
  }

  public static function SELECT_N_COUNT()
  {
    $sql= "SELECT meetups.*,
           (SELECT COUNT(*) FROM joined_meetups WHERE meetups.meetup_id = joined_meetups.meetup_id) AS members
           FROM meetups";
    $stmt = Db::$pdo->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $result;
  }

  function GET_USER_BY_NAME($name)
  {
    $sql= "SELECT * FROM users WHERE name = :name";
    $stmt = Db::$pdo->prepare($sql);
    $stmt->execute(array( 'name' => $name));
    $result = $stmt->fetch();

    return $result;
  }

  function GET_MEETUPS_BY_USER($id)
  {
    $sql= "SELECT * FROM meetups WHERE meetup_id IN (SELECT meetup_id FROM joined_meetups WHERE user_id = :id)";
    $stmt = Db::$pdo->prepare($sql);
    $stmt->execute(array( 'id' => $id ));
    $result = $stmt->fetchAll();

    return $result;
  }

  function JOIN_MEETUP($meetupId, $userId)
  {
    $stmt = Db::$pdo->prepare("INSERT INTO joined_meetups (meetup_id, user_id) VALUES (:meetupId, :userId)");
    $stmt->execute(array(
                    'meetupId' => $meetupId,
                    'userId' => $userId
                    ));
  }

  function UNJOIN_MEETUP($meetupId, $userId)
  {
    $sql = "DELETE FROM joined_meetups WHERE user_id = :user_id AND meetup_id = :meetup_id";
    $stmt = Db::$pdo->prepare($sql);
    $stmt->execute(array('user_id' => $userId,
                         'meetup_id' => $meetupId));

  }

  function SELECT_MEETUP_N_COUNT_MEMBERS($url, $userId)
  {
      $sql= "SELECT meetups.*,
              (SELECT COUNT(*) FROM joined_meetups WHERE joined_meetups.meetup_id = meetups.meetup_id) AS members,
              EXISTS(SELECT -1 FROM joined_meetups WHERE user_id = :userId AND meetup_id = meetups.meetup_id) AS joined
            from meetups
             WHERE meetups.url = :meetupId";

      $stmt = Db::$pdo->prepare($sql);
      $stmt->execute(array('userId' => $userId,
                           'meetupId' => $url));
      $result = $stmt->fetch();
      return $result;
  }

  function GET_MEMBERS($url)
  {
    $sql= "SELECT users.name, users.user_id, users.href
          FROM users
          LEFT JOIN meetups ON url = :url
            LEFT JOIN joined_meetups ON joined_meetups.meetup_id = meetups.meetup_id
          WHERE users.user_id = joined_meetups.user_id";
    $stmt = Db::$pdo->prepare($sql);
    $stmt->execute(array('url' => $url));
    $result = $stmt->fetchAll();
    return $result;
  }

  function GET_DISCUSSION($url)
  {
   $sql= "SELECT d.comment, d.discussion_id, d.date, u.name, u.avatar, u.user_id
          FROM discussion d, users u
          LEFT JOIN meetups ON url = :url
          WHERE d.user_id = u.user_id AND meetups.meetup_id = d.meetup_id
          ORDER BY date DESC";
    $stmt = Db::$pdo->prepare($sql);
    $stmt->execute(array('url' => $url));
    $result = $stmt->fetchAll();
    return $result;
  }

  function ADD_COMMENT($comment)
  {
    $stmt = Db::$pdo->prepare("INSERT INTO discussion (user_id, meetup_id, comment, date) VALUES (:user_id, :meetup_id, :comment, :date)");
    $stmt->execute(array(
                    'user_id' => $comment['user_id'],
                    'meetup_id' => $comment['meetup_id'],
                    'comment' => $comment['comment'],
                    'date' => time()
                  ));
  }

  function UPDATE_AVATAR($user_id, $avatar)
  {
    $stmt = Db::$pdo->prepare("UPDATE users SET avatar = :avatar WHERE user_id = :user_id");
    $stmt->execute(array(
                    'user_id' => $user_id,
                    'avatar' => $avatar));

  }

  function CREATE_MEETUP($meetup)
  {
    $stmt = Db::$pdo->prepare("INSERT INTO meetups (title, location, date, information, url, published, author_id) VALUES (:title, :location, :date, :information, :url, 0, :author_id)");
    $stmt->execute(array(
                    'title' => $meetup['title'],
                    'location' => $meetup['location'],
                    'date' => $meetup['date'],
                    'information' => $meetup['info'],
                    'url' => $meetup['url'],
                    'author_id' => $meetup['author_id']
                    ));
  }

  function GET_USER_BY_ID($id)
  {
    $stmt = Db::$pdo->prepare("SELECT user_id, name, email, avatar, information, href FROM users WHERE user_id = :id");
    $stmt->execute(array('id' => $id));
    $result = $stmt->fetch();
    return $result;
  }

  function SELECT_CONTACTS($id)
  {
    $sql = "SELECT * FROM contacts
            LEFT JOIN contact_type ON contacts.contact_type_id = contact_type.contact_type_id
            WHERE user_id = :id";
    $stmt = Db::$pdo->prepare($sql);
    $stmt->execute(array('id' => $id));
    $result = $stmt->fetchAll();
    return $result;
  }

  function SELECT_CONTACT_TYPE()
  {
    $stmt = Db::$pdo->prepare("SELECT * FROM contact_type");
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $result;
  }

  function INSERT_TO_CONTACTS($contact)
  {
    $stmt = Db::$pdo->prepare("INSERT INTO contacts (user_id, contact_type_id, contact) VALUES (:user_id, :contact_type_id, :contact)");
    $stmt->execute(array(
                    'user_id' => $contact['user_id'],
                    'contact_type_id' => $contact['contact_type_id'],
                    'contact' => $contact['contact'],
                    ));
    return Db::$pdo->lastInsertId();
  }

  function UPDATE_CONTACTS($contact)
  {
    $stmt = Db::$pdo->prepare("UPDATE contacts SET contact_type_id = :contact_type_id, contact = :contact WHERE contact_id = :contact_id");
    $stmt->execute(array(
                    'contact_type_id' => $contact['contact_type_id'],
                    'contact' => $contact['contact'],
                    'contact_id' => $contact['contact_id']
                    ));
  }

  function DELETE_CONTACT($contact)
  {
    $stmt = Db::$pdo->prepare("DELETE FROM contacts WHERE contact_id = :contact_id");
    $stmt->execute(array('contact_id' => $contact['contact_id']));
  }

  function GET_ORGANIZED_MEETUPS($id)
  {
    $sql= "SELECT *, (SELECT COUNT(*)
           FROM joined_meetups
           WHERE meetups.meetup_id = joined_meetups.meetup_id) AS members
           FROM meetups
           WHERE author_id = :author_id";
    $stmt = Db::$pdo->prepare($sql);
    $stmt->execute(array( 'author_id' => $id ));
    $result = $stmt->fetchAll();
    return $result;
  }

  function EDIT_MEETUP($meetup)
  {
    $type = $meetup['type'];

    $stmt = Db::$pdo->prepare("UPDATE meetups SET $type = :value WHERE meetup_id = :meetup_id");
    $stmt->execute(array(
                    'value' => $meetup['value'],
                    'meetup_id' => $meetup['meetup_id']));
  }
}
