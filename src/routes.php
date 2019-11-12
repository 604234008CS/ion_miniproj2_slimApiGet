<?php
header("Access-Control-Allow-Origin: *");
header("Content-type:application/json",true);

// get all todos
    $app->get('/todos', function ($request, $response, $args) {
         $sth = $this->db->prepare("SELECT * FROM tasks ORDER BY task");
        $sth->execute();
        $todos = $sth->fetchAll();
        return $this->response->withJson($todos);
    });
 
    // Retrieve todo with id 
    $app->get('/todo/[{id}]', function ($request, $response, $args) {
         $sth = $this->db->prepare("SELECT * FROM tasks WHERE id=:id");
        $sth->bindParam("id", $args['id']);
        $sth->execute();
        $todos = $sth->fetchObject();
        return $this->response->withJson($todos);
    });
 
 
    // Search for todo with given search teram in their name
    $app->get('/todos/search/[{query}]', function ($request, $response, $args) {
         $sth = $this->db->prepare("SELECT * FROM tasks WHERE UPPER(task) LIKE :query ORDER BY task");
        $query = "%".$args['query']."%";
        $sth->bindParam("query", $query);
        $sth->execute();
        $todos = $sth->fetchAll();
        return $this->response->withJson($todos);
    });
 
    // Add a new todo
    $app->post('/todo', function ($request, $response) {
        $input = $request->getParsedBody();
        $sql = "INSERT INTO tasks (task) VALUES (:task)";
         $sth = $this->db->prepare($sql);
        $sth->bindParam("task", $input['task']);
        $sth->execute();
        $input['id'] = $this->db->lastInsertId();
        return $this->response->withJson($input);
    });
        
 
    // DELETE a todo with given id
    $app->delete('/todo/[{id}]', function ($request, $response, $args) {
         $sth = $this->db->prepare("DELETE FROM tasks WHERE id=:id");
        $sth->bindParam("id", $args['id']);
        $sth->execute();
        $todos = $sth->fetchAll();
        return $this->response->withJson($todos);
    });
 
    // Update todo with given id
    $app->put('/todo/[{id}]', function ($request, $response, $args) {
        $input = $request->getParsedBody();
        $sql = "UPDATE tasks SET task=:task WHERE id=:id";
         $sth = $this->db->prepare($sql);
        $sth->bindParam("id", $args['id']);
        $sth->bindParam("task", $input['task']);
        $sth->execute();
        $input['id'] = $args['id'];
        return $this->response->withJson($input);
    });

    $app->get('/dorm', function ($request, $response, $args) {
        $sth = $this->db->prepare("SELECT
        room.room_id,
        room.room_name,
        room.address,
        room.price,
        room.detail,
        type.type_name,
        room.room_tel,
        room.sex,
        room.member_id,
        room.pic,
		picture.pic_name,
        picture.pic1,
        picture.pic2
    FROM room, type, picture
    WHERE room.type_id = type.type_id AND picture.room_id = room.room_id AND room.type_id LIKE '4%'");
       $sth->execute();
       $dorm = $sth->fetchAll();
       return $this->response->withJson($dorm);
   });

    $app->get('/rent', function ($request, $response, $args) {
        $sth = $this->db->prepare("SELECT
        room.room_id,
        room.room_name,
        room.address,
        room.price,
        room.detail,
        type.type_name,
        room.room_tel,
        room.sex,
        room.member_id,
        room.pic,
		picture.pic_name,
        picture.pic1,
        picture.pic2
    FROM room, type, picture
    WHERE room.type_id = type.type_id AND picture.room_id = room.room_id ORDER BY room.room_id ASC");
       $sth->execute();
       $rent = $sth->fetchAll();
       return $this->response->withJson($rent);
   });

   $app->get('/condo', function ($request, $response, $args) {
    $sth = $this->db->prepare("SELECT
    room.room_id,
    room.room_name,
    room.address,
    room.price,
    room.detail,
    type.type_name,
    room.room_tel,
    room.sex,
    room.member_id,
    room.pic,
    picture.pic_name,
    picture.pic1,
    picture.pic2
FROM room, type, picture
WHERE room.type_id = type.type_id AND picture.room_id = room.room_id AND room.type_id LIKE '1%'");
   $sth->execute();
   $condo = $sth->fetchAll();
   return $this->response->withJson($condo);
    });

   $app->get('/apartment', function ($request, $response, $args) {
    $sth = $this->db->prepare("SELECT
    room.room_id,
    room.room_name,
    room.address,
    room.price,
    room.detail,
    type.type_name,
    room.room_tel,
    room.sex,
    room.member_id,
    room.pic,
    picture.pic_name,
    picture.pic1,
    picture.pic2
FROM room, type, picture
WHERE room.type_id = type.type_id AND picture.room_id = room.room_id AND room.type_id LIKE '2%'");
   $sth->execute();
   $apartment = $sth->fetchAll();
   return $this->response->withJson($apartment);
    });

   $app->get('/mansion', function ($request, $response, $args) {
    $sth = $this->db->prepare("SELECT
    room.room_id,
    room.room_name,
    room.address,
    room.price,
    room.detail,
    type.type_name,
    room.room_tel,
    room.sex,
    room.member_id,
    room.pic,
    picture.pic_name,
    picture.pic1,
    picture.pic2
FROM room, type, picture
WHERE room.type_id = type.type_id AND picture.room_id = room.room_id AND room.type_id LIKE '3%'");
   $sth->execute();
   $mansion = $sth->fetchAll();
   return $this->response->withJson($mansion);
});

   $app->get('/rent/search/[{query}]', function ($request, $response, $args) {
    $sth = $this->db->prepare("SELECT * FROM room WHERE room_name LIKE :query ORDER BY room_name");
   $query = "%".$args['query']."%";
   $sth->bindParam("query", $query);
   $sth->execute();
   $rents = $sth->fetchAll();
   return $this->response->withJson($rents);
});

$app->get('/rent3000', function ($request, $response, $args) {
    $sth = $this->db->prepare("SELECT
    room.room_id,
    room.room_name,
    room.address,
    room.price,
    room.detail,
    type.type_name,
    room.room_tel,
    room.sex,
    room.member_id,
    room.pic,
    picture.pic_name,
    picture.pic1,
    picture.pic2
FROM room, type, picture
WHERE room.type_id = type.type_id AND picture.room_id = room.room_id AND room.price < 3000");
   $sth->execute();
   $rent = $sth->fetchAll();
   return $this->response->withJson($rent);
});

$app->get('/rent3001', function ($request, $response, $args) {
    $sth = $this->db->prepare("SELECT
    room.room_id,
    room.room_name,
    room.address,
    room.price,
    room.detail,
    type.type_name,
    room.room_tel,
    room.sex,
    room.member_id,
    room.pic,
    picture.pic_name,
    picture.pic1,
    picture.pic2
FROM room, type, picture
WHERE room.type_id = type.type_id AND picture.room_id = room.room_id AND room.price BETWEEN '3000%' AND '4000%'");
   $sth->execute();
   $rent = $sth->fetchAll();
   return $this->response->withJson($rent);
});

$app->get('/rent4000', function ($request, $response, $args) {
    $sth = $this->db->prepare("SELECT
    room.room_id,
    room.room_name,
    room.address,
    room.price,
    room.detail,
    type.type_name,
    room.room_tel,
    room.sex,
    room.member_id,
    room.pic,
    picture.pic_name,
    picture.pic1,
    picture.pic2
FROM room, type, picture
WHERE room.type_id = type.type_id AND picture.room_id = room.room_id AND room.price > 4000");
   $sth->execute();
   $rent = $sth->fetchAll();
   return $this->response->withJson($rent);
});

$app->get('/room/[{room_name}]', function ($request, $response, $args) {
    $sth = $this->db->prepare("SELECT
    room.room_id,
    room.room_name,
    room.address,
    room.price,
    room.detail,
    type.type_name,
    room.room_tel,
    room.sex,
    room.member_id,
    room.pic
FROM room, type
WHERE room.type_id = type.type_id AND room_name = :room_name");
    $sth->bindParam("room_name", $args['room_name']);
   $sth->execute();
   $room = $sth->fetchAll();
   return $this->response->withJson($room);
});

$app->get('/review', function ($request, $response, $args) {
    $sth = $this->db->prepare("SELECT
	review.review_detail
FROM room, review
WHERE room.room_id = review.room_id");
   $sth->execute();
   $review = $sth->fetchAll();
   return $this->response->withJson($review);
});

