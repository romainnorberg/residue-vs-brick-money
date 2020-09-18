- `composer install`
- `php run-benchmark.php`

```
Benchmark romainnorberg/residue vs brick/money
==============================================

Host info
---------

 ------------- ------------------------- 
  Param         Value                    
 ------------- ------------------------- 
  time          2020-09-28 07:37:54 UTC  
  php_version   7.4.10                   
  platform      Darwin                   
  server_name                            
  server_addr                            
  xdebug        OFF                      
  iterator      20000                    
 ------------- ------------------------- 

Instantiation
-------------

 ----------------------- ---------------- ----------------- ------------------ 
  Package                 Execution time   Memory used       Peak memory used  
 ----------------------- ---------------- ----------------- ------------------ 
  romainnorberg/residue   0.000            17KB of memory    0KB of memory     
  brick/money             0.003            569KB of memory   587KB of memory   
 ----------------------- ---------------- ----------------- ------------------ 

Basic split
-----------

 e.g. 100/3 = [33.34, 33.33, 33.33]                                                                                     

 ----------------------- ---------------- ---------------- ------------------ 
  Package                 Execution time   Memory used      Peak memory used  
 ----------------------- ---------------- ---------------- ------------------ 
  romainnorberg/residue   0.034            1KB of memory    0KB of memory     
  brick/money             0.919            40KB of memory   16KB of memory    
 ----------------------- ---------------- ---------------- ------------------ 

Rounding/step split
-------------------

 e.g. 100/3 (with 0.05 step) = [33.35, 33.35, 33.30]                                                                    

 ----------------------- ---------------- --------------- ------------------ 
  Package                 Execution time   Memory used     Peak memory used  
 ----------------------- ---------------- --------------- ------------------ 
  romainnorberg/residue   0.032            0KB of memory   0KB of memory     
  brick/money             1.437            5KB of memory   0KB of memory     
 ----------------------- ---------------- --------------- ------------------ 
```
