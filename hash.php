<?php
echo 'Path logo: ' . FCPATH . 'uploads/logo.png' . '<br>';
echo 'Apakah ada? ';
echo file_exists(FCPATH . 'uploads/logo.png') ? 'Ya' : 'Tidak';
?>