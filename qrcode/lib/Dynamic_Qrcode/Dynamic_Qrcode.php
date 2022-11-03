<?php

require_once 'config/config.php';

include   '../vendor/autoload.php';


use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;


class Dynamic_Qrcode
{

    /**
     *
     */
    public function __construct()
    {
    }

    /**
     *
     */
    public function __destruct()
    {
    }
    
    /**
     * Set friendly columns\' names to order tables\' entries
     * N.B. This function is called to generate the "list all" table
     */
    public function setOrderingValues()
    {
        $ordering = [
            'id' => 'ID',
            'filename' => 'File Name',
            'identifier' => 'Identifier',
            'link' => 'Link',
            'qrcode' => 'Qr Code',
            'created_at' => 'Created at',
            'updated_at' => 'Updated at'
        ];

        return $ordering;
    }
    
    /**
     * This private function is used by both add () and edit () of this class to initially store in the array that will be sent to the database the:
     * filename, created_at, link
     */
    private function collect()
    {
    
    $data_to_db['filename'] = htmlspecialchars($_POST['filename'], ENT_QUOTES, 'UTF-8');
    $data_to_db['created_at'] = date('Y-m-d');
    $data_to_db['link'] = htmlspecialchars($_POST['link'], ENT_QUOTES, 'UTF-8');
    $data_to_db['created_by'] = $_SESSION['user_id']; 
    
    $db = getDbInstance();
    $user_id = $_SESSION['user_id'];
    $username = $db->query("SELECT user_name FROM user_accounts where id = $user_id");
    $user_name = implode(";",array_map("implode",$username));

    $data_to_db['created_by_user'] = $user_name;
    
    return $data_to_db;
    }
    
    /**
     * Set option for qr code like:
     * Error Correction Level, size (default = 100), foreground, background
     * return array of values
     */
    private function setOptions()
    {
        $errorCorrectionLevel = 'L';
    if (isset($_POST['level']) && in_array($_POST['level'], array('L','M','Q','H')))
        $errorCorrectionLevel = $_POST['level'];   
      
    $size = 100;
    if (isset($_POST['size']))
        $size = min(max((int)$_POST['size'], 100), 1000);
    
    $foreground = substr($_POST['foreground'], 1);                      // We eliminate the character "#" for the hexadecimal color
    $background = substr($_POST['background'], 1);
       
       return array(
            "errorCorrectionLevel" => $errorCorrectionLevel, 
            "size" => $size, 
            "foreground" => $foreground, 
            "background" => $background,
            ); 
    }
    
    public function add()
    {
        $data_to_db = $this->collect();
        $data_to_db['format'] = $_POST['format'];
        // for the identifier we create a random alphanumeric string through the function "randomString" in helpers.php > config.php
        $data_to_db['identifier'] = randomString(rand(5,8));
        $data_to_db['qrcode'] = $data_to_db['filename'].'.'.$data_to_db['format'];

        
        $options = $this->setOptions();

        if(!file_exists(DIRECTORY.$data_to_db['filename'].'.'.$data_to_db['format'])){
            $filename = DIRECTORY.$data_to_db['filename'].'.'.$data_to_db['format'];

            $split = str_split($options['foreground'], 2);
            $forground_r = hexdec($split[0]);
            $forground_g = hexdec($split[1]);
            $forground_b = hexdec($split[2]);

            $split2 = str_split($options['background'],2);
            $background_r = hexdec($split2[0]);
            $background_g = hexdec($split2[1]);
            $background_b = hexdec($split2[2]);


            $writer = new PngWriter();

            // Create QR code
            $qrCode = QrCode::create(READ_PATH . $data_to_db['identifier'])
                ->setEncoding(new Encoding('UTF-8'))
                ->setErrorCorrectionLevel(new ErrorCorrectionLevelHigh())
                ->setSize($options['size'])
                ->setMargin(10)
                ->setRoundBlockSizeMode(new RoundBlockSizeModeMargin())
                ->setForegroundColor(new Color($forground_r,  $forground_g, $forground_b))
                ->setBackgroundColor(new Color($background_r, $background_g,  $background_b));

            // Create generic logo
            $logo_path = 'images/php_logo.jpg'; // add logo here
            $logo = Logo::create( $logo_path)
                ->setResizeToWidth(30);
            

            // Create generic label
            $label = Label::create('QRCode') // change qr code label here
                ->setTextColor(new Color($forground_r, $forground_g, $forground_b));

            $result = $writer->write($qrCode, $logo, $label);


            // Save it to a file
            $result->saveToFile($filename);
              
            $db = getDbInstance();
            $last_id = $db->insert('dynamic_qrcodes', $data_to_db);
            }
            else
                $this->failure('You cannot create a new qr code with an existing name on the server!');
            
            if ($last_id){
                $this->success('Qr code added successfully!');
            }
            else{
            echo 'Insert failed: ' . $db->getLastError();
            exit();
            }
        }
    
    /**
     * Edit qr code
     * 
     */
    public function edit()
    {
        $db = getDbInstance();
        
        $dynamic_id = htmlspecialchars($_GET['dynamic_id'], ENT_QUOTES, 'UTF-8');           // get dynamic id
        $old_filename = htmlspecialchars($_GET['filename'], ENT_QUOTES, 'UTF-8');           // get filename
        
        $query = $db->query("SELECT format FROM dynamic_qrcodes WHERE id=$dynamic_id");     // get format
        $format = $query[0]['format'];
        
        $data_to_db = $this->collect();
        $data_to_db['state'] = $_POST['state'];                                             // update link state
        $data_to_db['qrcode'] = $data_to_db['filename'].'.'.$format;                        // update qrcode in db

        if(!file_exists(DIRECTORY.$data_to_db['filename'].'.'.$format) || $data_to_db['filename'] == $old_filename){
            $db->where('id', $dynamic_id);
            $stat = $db->update('dynamic_qrcodes', $data_to_db);
            
            try{
                rename(DIRECTORY.$old_filename.'.'.$format, DIRECTORY.$data_to_db['filename'].'.'.$format);
            }
            catch(Exception $e){
                $this->failure($e->getMessage());
            }
        }
        else
            $this->failure('You cannot edit a qr code with an existing name on the server!');
        
        if ($stat){
            $this->success('Qr code updated successfully!');
        }
        else{
        echo 'Insert failed: ' . $db->getLastError();
        exit();
        }
    }
    
    /**
     * Delete qr code
     * 
     */
    public function cancel($dynamic_id, $filename)
    {
        // if($_SESSION['user_type']!='admin')
        //     $this->failure('You don\'t have permission to perform this action');
        
        $db = getDbInstance();
        
        $query = $db->query("SELECT format FROM dynamic_qrcodes WHERE id=$dynamic_id");     
        $format = $query[0]['format'];
        
        $db->where('id', $dynamic_id);
        $status = $db->delete('dynamic_qrcodes');
        
        try{
            unlink(DIRECTORY.$filename.'.'.$format);
        }
        catch(Exception $e){
            $this->failure($e->getMessage());
        }

        if ($status)
            $this->info('Qr code deleted successfully!');
        else
            $this->failure('Unable to delete qr code');
    }
    
                                    /* FLASH MESSAGE */
/* 3 functions for 3 types of messages with different styles defined in the flash_message.php file 
Each function takes a string as input and after a redirection it prints the desired message
*/
    
    
    /**
     * Flash message Failure process
     */
    private function failure($message)
    {
        $_SESSION['failure'] = $message;
        // Redirect to the listing page
        header('Location: dynamic_qrcodes.php');
        // Important! Don't execute the rest put the exit/die.
    	exit();
    }
    
    /**
     * Flash message Success process
     */
    private function success($message)
    {
        $_SESSION['success'] = $message;
        // Redirect to the listing page
        header('Location: dynamic_qrcodes.php');
        // Important! Don't execute the rest put the exit/die.
    	exit();
    }
    
    /**
     * Flash message Info process
     */
    private function info($message)
    {
        $_SESSION['info'] = $message;
        // Redirect to the listing page
        header('Location: dynamic_qrcodes.php');
        // Important! Don't execute the rest put the exit/die.
    	exit();
    }
    
}
?>
