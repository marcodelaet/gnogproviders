<?php
Class Sendmail{
    private $sender_name;
    private $sender_email;
    private $to_name;
    private $to_email;
    private $body_text;
    private $file_object;
    private $fileName;
    private $fileType;
    private $attached_file = '';
    private $boundary;
    private $headers;
    private $messageHTML;

    public function setSenderName($string){
        $this->sender_name = $string;
    }

    public function setSenderEmail($string){
        $this->sender_email = $string;
    }

    public function setToName($string){
        $this->to_name = $string;
    }

    public function setToEmail($string){
        $this->to_email = $string;
    }

    public function setBodyText($string){
        $this->body_text = $string;
    }

    public function setBoundary($module){
        $this->boundary = "GNOG-".md5(date("dmYis"))."-".strtoupper($module);
    }

    public function setFile($filePath){
        $path = $filePath;
        $this->fileType = mime_content_type( $path );
        $this->fileName = basename( $path );

        // creating the attached file
        $fp = fopen( $path, "rb" ); // open file
        $attached_file_local = fread( $fp, filesize( $path ) ); // Calculating file size
        $this->attached_file = chunk_split(base64_encode( $attached_file_local )); // encoding file in 64 Bits
        fclose( $fp ); // Close file
    }

    public function setHeaders(){
        $headersLocal = "MIME-Version: 1.0" . PHP_EOL;
        $headersLocal .= "Content-Type: multipart/mixed; ";
        $headersLocal .= "From: $this->sender_name <$this->sender_email>";
        $headersLocal .= "boundary=" . $this->boundary . PHP_EOL;
        $this->headers = $headersLocal . "$this->boundary" . PHP_EOL;
    }

    public function setMessage($bodyHTML){
        $this->setBodyText($bodyHTML);
        $messageLocalHTML  = "--$this->boundary" . PHP_EOL;
        $messageLocalHTML .= "Content-Type: text/html; charset='utf-8'" . PHP_EOL;
        $messageLocalHTML .= "$this->body_text"; // Add here message to send
        $messageLocalHTML .= "<img src='$this->attached_file' />";
        $this->messageHTML = $messageLocalHTML . "--$this->boundary" . PHP_EOL;
    }

    public function addAttachedFile($filePath){
        $this->setFile($filePath);
        $messageLocalHTML = "Content-Type: ". $this->fileType ."; name=\"". $this->fileName . "\"" . PHP_EOL;
        $messageLocalHTML .= "Content-Transfer-Encoding: base64" . PHP_EOL;
        $messageLocalHTML .= "Content-Disposition: attachment; filename=\"". $this->fileName . "\"" . PHP_EOL;
        $messageLocalHTML .= "$this->attached_file" . PHP_EOL;
        $this->messageHTML = $messageLocalHTML . "--$this->boundary" . PHP_EOL;
    }

    public function sendGNogMail($from_name,$from_email,$to_name,$to_email,$subject,$messageHtml,$signFilePath){
        $this->setSenderName($from_name);
        $this->setSenderEmail($from_email);
        $this->setToName($to_name);
        $this->setToEmail($to_email);
        $this->setBoundary('providers');
        $this->setHeaders();
        $this->addAttachedFile($signFilePath);
        $this->setBodyText($messageHtml);

        $to = $this->to_name . "<$this->to_email>";

        mail($to, $subject, $this->messageHTML, $this->headers);
    }

}
?>