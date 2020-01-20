<?php
namespace App\Service;
class GenererNumeroCompte{
    public function generer($nbrCompte){
        return sprintf("NCP-%05d",$nbrCompte);
    }
}