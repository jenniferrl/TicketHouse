<?php
    function formatUang($inputan){
        $hasil = "";
        $ctr = 0; 
        for ($i=strlen($inputan)-1; $i >= 0; $i--) {
          if($ctr < 3){
            $hasil.= substr($inputan, $i, 1);
            $ctr = $ctr+1;
          }
      
          if($ctr == 3){
            if($i != 0){
              $hasil.=".";
            }
            $ctr = 0;
          }
        }
      
        $hasilFlip = "";
        for ($i=strlen($hasil)-1; $i >=0 ; $i--) { 
          $hasilFlip.=substr($hasil, $i, 1);
        }
      
        return $hasilFlip;
    }
?>