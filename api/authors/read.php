<?php

  // Read Author query
  $result = $author->read();
  // Get row count
  $num = $result->rowCount();

  // check if any authors
  if ($num > 0) {
    // Author array
    $author_arr = array();
    $author_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $author_item = array(
          'id' => $id,
          'author' => $author
        );

        // Push to "data"
        array_push($author_arr['data'], $author_item);

        // Turn to JSON and output
        echo json_encode($posts_arr);
    }
  } else {
    // No Authors
    echo json_encode(
      array('message' => 'No Authors Found')
    );
  }
?>