        if ($request["title"] == "") {
          header("HTTP/1.1 400");
          $validation_messages = array();
          $validation_messages["title"] = "Der Titel ist eine Pflichtangabe. Bitte geben Sie einen Titel an.";
          echo json_encode($validation_messages);
          return;
        }