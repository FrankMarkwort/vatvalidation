<?php

require_once __DIR__ . '/../../src/vat_validation_frank.php';

class vat_validation_mock extends vat_validation_frank
{
    
    protected function get_customer_status_from_databas(?int $customers_id): ?int
    {       
        return $this->dbMock($customers_id);
    }
    
    protected function dbMock($customers_id) 
    {
        $table = [
            1 => 1,
            2 => 2,
            3 => 3,
            10 => 0
        ];
        
        return $table[$customers_id];
    }
}
