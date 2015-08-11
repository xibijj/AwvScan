# coding=utf-8
import urllib,time,os,base64,json
import _winreg

wvs_path = ""

def get_html(url):
	url=url.strip()
	html=urllib.urlopen(url).read()
	return html
	
def writefile(logname,cmd):
	try:
		fp = open(logname,'a')
		fp.write(cmd+"\n")
		fp.close()
	except:
		return False
		
def regedit(re_root,re_path,re_key):
	try:
		key = _winreg.OpenKey(_winreg.HKEY_LOCAL_MACHINE,re_path)
		value,type = _winreg.QueryValueEx(key,re_key)
		return value
	except:
		return False
		
def get_console(url):
	now = time.strftime('%Y-%m-%d %X', time.localtime(time.time()))
	date = time.strftime('%Y-%m-%d', time.localtime(time.time()))
	try:
		a = get_html(url)
		#print a
		if len(a) > 50:
			base = base64.b64decode(a)
			#print base
			json_arr = json.loads(base)
			target_url = json_arr['target_url']
			user = json_arr['siteuser']
			pwd = json_arr['sitepwd']
			scan_rule = json_arr['scan_rule']
			hash = json_arr['hash']
			print json_arr
			console = '"%s\\wvs_console.exe" /Scan %s --HtmlAuthUser=%s --HtmlAuthPass=%s --EnablePortScanning=True /Verbose /ExportXML /SaveLogs /SaveFolder E:\\wwwroot\\report\\%s\\' %(wvs_path,target_url,user,pwd,hash)
			#console = console + '\ndel %0'
			scantime = time.strftime('%Y-%m-%d %X', time.localtime(time.time()))
			print "%s\n%s\n" %(scantime,console)
			writefile('bat\\%s.bat'%hash,console)
			cmd = 'cmd /c bat\\%s.bat' %hash
			print "%s\n%s\n%s\n" %(now,target_url,cmd)
			os.system(cmd)
	except Exception , e:
		info = '%s\nError: %s' %(now,e)
		writefile('logs\\%s-Error.log'%date,info)
		print info
		

wvs_path = regedit(0,"SOFTWARE\Acunetix\WVS9","Path")
#exit()
url = 'http://10.118.44.8/scan/tasklist.php'
i = 0
while 1:
	now = time.strftime('%Y-%m-%d %X', time.localtime(time.time()))
	try:
		a = get_console(url)
		i +=1
		time.sleep(5)
	except Exception , e:
		info = '%s\nError: %s' %(now,e)
		writefile('Error.log',info)
		print info
		time.sleep(1)