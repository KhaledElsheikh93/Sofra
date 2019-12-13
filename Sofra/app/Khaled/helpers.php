<?php 
   
  function  responseJson($status, $msg, $data= null)
  {
      if($data == null)
      {
          $response = [
              'status' => $status,
              'msg'    => $msg
          ];
          return response()->json($response);
      }
      $response = [
          'status' => $status,
          'msg'    => $msg,
          'data'   => $data
      ];
      return response()->json($response);
  }

  function settings()
  {
      $settings = \App\Models\Setting::find(1);
      if($settings)
      {
          return $settings;
      }
      else
      {
          return new \App\Models\Setting;
      }
  }


  function notifyByFirebase($title,$body,$tokens,$data = [])        // parameter 5 =>>>> $type
    {
        $registrationIDs = $tokens;
        $fcmMsg = array(
            'body' => $body,
            'title' => $title,
            'sound' => "default",
            'color' => "#203E78"
        );
        $fcmFields = array(
            'registration_ids' => $registrationIDs,
            'priority' => 'high',
            'notification' => $fcmMsg,
            'data' => $data
        );
        $headers = array(
            'Authorization: key='.env('FIREBASE_API_ACCESS_KEY'),
            'Content-Type: application/json'
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmFields));
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
  
