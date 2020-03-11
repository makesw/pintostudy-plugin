<?php 
session_start();
$uploadDir = dirname(__FILE__) . '/uploadFile/';
require_once(dirname(__FILE__) . '/conexion.php');
$targetFilePath;
$fileName = "databasePintoStudy.xlsx";
$targetFilePath = $uploadDir . $fileName;
$response = array(
    'status' => 0,
    'message' => 'Form submission failed, please try again.',
    'insertsPrograms' => 0,
    'insertsUniversity' => 0
);
$optionRadio='';
if( isset($_POST[ "radio" ]) ){
    $optionRadio = $_POST[ "radio" ];
}
$uploadedFile = '';
if( !empty ($_FILES["file"]["name"]) ){
    // File path config
    $fileName = basename($_FILES["file"]["name"]);
    if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){
        $response['status'] = 1;
        $response['message'] = 'File Upluad, SuccessFull.';
        $uploadedFile = $fileName;
    }else{
        $response['message'] = 'Sorry, there was an error uploading your file.';
    } 
}
if( $response['status'] == 1 ){ //proccess file uploaded
    include dirname(__FILE__).'/PHPExcel/Classes/PHPExcel/IOFactory.php';
    $inputFileName = $targetFilePath;
    //  Read your Excel workbook
    try {
        $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        $objPHPExcel = $objReader->load($inputFileName);
    } catch(Exception $e) {
        $response['status'] = 0;
        $response['message'] = $e->getMessage();
        die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
    }
    
    if( !empty($optionRadio) && $optionRadio=='programs' ){ //Actualizar solo BD Programas
        //Get worksheet dimensions PROGRAMAS
        $sheet = $objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();
        $totalInsertsProgram = 0;
        
        //Clean DB program:
        $connect->query("DELETE FROM program");
        
        //  Loop through each row of the worksheet in turn
        for ($row = 2; $row <= $highestRow; $row++){
            //  Insert row data array into your database of choice here
            $rowData = $sheet->rangeToArray('A'.$row.':T'.$row);
            $insert = "INSERT INTO program
                (columna_1, columna_2, columna_3, columna_4, columna_5, columna_6, columna_7, columna_8, columna_9, columna_10,
                columna_11, columna_12,columna_13, columna_14, columna_15, columna_16, columna_17, columna_18, columna_19, columna_20)
                VALUES
                ('".$rowData[0][0]."','".$rowData[0][1]."','".$rowData[0][2]."','".$rowData[0][3]."','".$rowData[0][4]."',
                '".$rowData[0][5]."','".$connect->real_escape_string($rowData[0][6])."','".$rowData[0][7]."','".$rowData[0][8]."',
                '".$rowData[0][9]."','".$rowData[0][10]."','".$rowData[0][11]."','".$rowData[0][12]."','".$rowData[0][13]."',
                '".$rowData[0][14]."','".$connect->real_escape_string($rowData[0][15])."','".$connect->real_escape_string($rowData[0][16])."',
                '".$connect->real_escape_string($rowData[0][17])."','".$connect->real_escape_string($rowData[0][18])."','".$rowData[0][19]."')";
            $resultInsert = $connect->query($insert);
            $totalInsertsProgram+= $resultInsert;
        }
        $response['insertsPrograms'] = $totalInsertsProgram;
        if($totalInsertsProgram >= $highestRow){
            $response['status'] = 1;
        }
    }else if( !empty($optionRadio) && $optionRadio=='universities' ){//Actualizar solo BD Universidades
        //Get worksheet dimensions UNIVERSIDADES
        $sheet = $objPHPExcel->getSheet(1);
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();
        $totalInsertsUniversity = 0;
        
        //Clean DB university:
        $connect->query("DELETE FROM university");
        
        //  Loop through each row of the worksheet in turn
        for ($row = 2; $row <= $highestRow; $row++){
            //  Insert row data array into your database of choice here
            $rowData = $sheet->rangeToArray('A'.$row.':AI'.$row);
            $insert = "INSERT INTO university(columna_1, columna_2, columna_3, columna_4, columna_5, columna_6, columna_7,
        columna_8, columna_9, columna_10, columna_11, columna_12, columna_13, columna_14, columna_15, columna_16,
        columna_17, columna_18, columna_19, columna_20, columna_21, columna_22, columna_23, columna_24, columna_25,
        columna_26, columna_27, columna_28, columna_29, columna_30, columna_31, columna_32, columna_33, columna_34,
        columna_35)
        VALUES
        ('".$rowData[0][0]."','".$rowData[0][1]."','".$rowData[0][2]."','".$rowData[0][3]."','".$rowData[0][4]."','".trim($rowData[0][5])."',
        '".trim($rowData[0][6])."','".$rowData[0][7]."','".$rowData[0][8]."','".$rowData[0][9]."','".$rowData[0][10]."','".$rowData[0][11]."',
        '".$rowData[0][12]."','".$rowData[0][13]."','".$rowData[0][14]."','".$rowData[0][15]."','".$rowData[0][16]."','".$connect->real_escape_string($rowData[0][17])."',
        '".$rowData[0][18]."','".$rowData[0][19]."','".$rowData[0][20]."','".$rowData[0][21]."','".$rowData[0][22]."','".$rowData[0][23]."',
        '".$rowData[0][24]."','".$rowData[0][25]."','".$rowData[0][26]."','".$rowData[0][27]."','".$rowData[0][28]."','".$connect->real_escape_string($rowData[0][29])."',
        '".$connect->real_escape_string($rowData[0][30])."','".$rowData[0][31]."','".$rowData[0][32]."','".$rowData[0][33]."','".$rowData[0][34]."')";
            $resultInsert = $connect->query($insert);
            $totalInsertsUniversity+= $resultInsert;
        }
        $response['insertsUniversity'] = $totalInsertsUniversity;
        if($totalInsertsUniversity >= $highestRow){
            $response['status'] = 1;
        }
    }else {//Actualizar BD Programas y Universidades
        //Get worksheet dimensions PROGRAMAS
        $sheet = $objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();
        $totalInsertsProgram = 0;
        
        //Clean DB program:
        $connect->query("DELETE FROM program");
        //Clean DB university:
        $connect->query("DELETE FROM university");
        
        //  Loop through each row of the worksheet in turn
        for ($row = 2; $row <= $highestRow; $row++){
            //  Insert row data array into your database of choice here
            $rowData = $sheet->rangeToArray('A'.$row.':T'.$row);
            $insert = "INSERT INTO program
                (columna_1, columna_2, columna_3, columna_4, columna_5, columna_6, columna_7, columna_8, columna_9, columna_10,
                columna_11, columna_12,columna_13, columna_14, columna_15, columna_16, columna_17, columna_18, columna_19, columna_20)
                VALUES
                ('".$rowData[0][0]."','".$rowData[0][1]."','".$rowData[0][2]."','".$rowData[0][3]."','".$rowData[0][4]."',
                '".$rowData[0][5]."','".$connect->real_escape_string($rowData[0][6])."','".$rowData[0][7]."','".$rowData[0][8]."',
                '".$rowData[0][9]."','".$rowData[0][10]."','".$rowData[0][11]."','".$rowData[0][12]."','".$rowData[0][13]."',
                '".$rowData[0][14]."','".$connect->real_escape_string($rowData[0][15])."','".$connect->real_escape_string($rowData[0][16])."',
                '".$connect->real_escape_string($rowData[0][17])."','".$connect->real_escape_string($rowData[0][18])."','".$rowData[0][19]."')";
            $resultInsert = $connect->query($insert);
            $totalInsertsProgram+= $resultInsert;
        }
        $response['insertsPrograms'] = $totalInsertsProgram;
        if($totalInsertsProgram >= $highestRow){
            $response['status'] = 1;
        }
        
        //Get worksheet dimensions UNIVERSIDADES
        $sheet = $objPHPExcel->getSheet(1);
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();
        $totalInsertsUniversity = 0;
        //  Loop through each row of the worksheet in turn
        for ($row = 2; $row <= $highestRow; $row++){
            //  Insert row data array into your database of choice here
            $rowData = $sheet->rangeToArray('A'.$row.':AI'.$row);
            $insert = "INSERT INTO university(columna_1, columna_2, columna_3, columna_4, columna_5, columna_6, columna_7,
        columna_8, columna_9, columna_10, columna_11, columna_12, columna_13, columna_14, columna_15, columna_16,
        columna_17, columna_18, columna_19, columna_20, columna_21, columna_22, columna_23, columna_24, columna_25,
        columna_26, columna_27, columna_28, columna_29, columna_30, columna_31, columna_32, columna_33, columna_34,
        columna_35)
        VALUES
        ('".$rowData[0][0]."','".$rowData[0][1]."','".$rowData[0][2]."','".$rowData[0][3]."','".$rowData[0][4]."','".$rowData[0][5]."',
        '".$rowData[0][6]."','".$rowData[0][7]."','".$rowData[0][8]."','".$rowData[0][9]."','".$rowData[0][10]."','".$rowData[0][11]."',
        '".$rowData[0][12]."','".$rowData[0][13]."','".$rowData[0][14]."','".$rowData[0][15]."','".$rowData[0][16]."','".$connect->real_escape_string($rowData[0][17])."',
        '".$rowData[0][18]."','".$rowData[0][19]."','".$rowData[0][20]."','".$rowData[0][21]."','".$rowData[0][22]."','".$rowData[0][23]."',
        '".$rowData[0][24]."','".$rowData[0][25]."','".$rowData[0][26]."','".$rowData[0][27]."','".$rowData[0][28]."','".$connect->real_escape_string($rowData[0][29])."',
        '".$connect->real_escape_string($rowData[0][30])."','".$rowData[0][31]."','".$rowData[0][32]."','".$rowData[0][33]."','".$rowData[0][34]."')";
            $resultInsert = $connect->query($insert);
            $totalInsertsUniversity+= $resultInsert;
        }
        $response['insertsUniversity'] = $totalInsertsUniversity;
        if($totalInsertsUniversity >= $highestRow){
            $response['status'] = 1;
        }
    }
    
    
    
    
    
    
}
// Return response
echo json_encode($response);
?>