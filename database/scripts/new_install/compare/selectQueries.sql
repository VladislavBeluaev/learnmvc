select count(`clock_frequency`) as QTY,core_num,clock_frequency,price from mobile group by core_num,clock_frequency,price;