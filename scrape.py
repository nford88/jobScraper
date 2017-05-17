from ConfigParser import SafeConfigParser
import MySQLdb
from bs4 import BeautifulSoup
import urllib2
import time
from datetime import datetime
import pprint
# import pdb
# pdb.set_trace()

parser = SafeConfigParser()
parser.read('jobscraper-config.ini')

host = parser.get('database', 'hostname')
username = parser.get('database', 'username')
password = parser.get('database', 'password')
dbname = parser.get('database', 'dbname')

# print host, username, password, dbname

db = MySQLdb.connect(host=host, user=username, passwd=password, db=dbname, use_unicode=True,charset='UTF8')
cur = db.cursor()

def jobbioParse():
	
	quote_page = 'https://jobbio.com/search/jobs?query=Developer&location=dublin&sector='
	page = urllib2.urlopen(quote_page)
	soup = BeautifulSoup(page, 'html.parser')
	divs = soup.findAll(class_= 'job-item')

	for div in divs:
		role_box =  div.find(attrs={'class': 'color-dark-grey'})
		role = role_box.text.strip() # strip() is used to remove starting and trailing
		company_box =  div.find(attrs={'class': 'color-greenish-blue'})
		company = company_box.text.strip() # strip() is used to remove starting and trailing
		location_box =  div.find(attrs={'class': 'color-grey'})
		location = location_box.text.strip() # strip() is used to remove starting and trailing
		url_box =  div.find(attrs={'class': 'job-tile-actions'}).a['href']
		url_root = 'http://jobbio.com'
		url = url_root + url_box
		salary = 'Negotiable'
		dates = time.strftime("%Y/%m/%d")

		# jobbio = {'role':str(role), 'company': str(company), 'location': str(location), 'salary': str(salary), 'dates':dates, 'url': str(url)}
		loggit = "INSERT IGNORE INTO jobScraper (role, company, location, url, salary, dates) VALUES (%s, %s, %s, %s, %s, %s)"
		cur.execute(loggit, (role, company, location, url, salary, dates))
		db.commit()
		#pp = pprint.PrettyPrinter(indent=4)
		#pp.pprint(jobbio)

def irishjobsParse():
	
	quote_page = 'http://www.irishjobs.ie/ShowResults.aspx?Keywords=developer+not+senior+not+.net+not+java+not+manager&Location=102&Category=&Recruiter=All&SortBy=MostRecent&PerPage=300'
	req = urllib2.Request(quote_page, headers={ 'User-Agent': 'Mozilla/5.0' })
	page = urllib2.urlopen(req).read()
	soup = BeautifulSoup(page, 'html.parser')
	divs = soup.findAll(class_= 'job-result')

	for div in divs:
		role_box =  div.find(attrs={'class': 'job-result-title'}).h2.a
		role = role_box.text.strip().replace(u'\u2013',u'-')  # strip() is used to remove starting and trailing
		company_box =  div.find(attrs={'class': 'job-result-title'}).h3.a
		company = company_box.text.strip().replace(u'\u2013',u'-')  # strip() is used to remove starting and trailing
		location_box =  div.find(attrs={'class': 'location'}).a
		location = location_box.text.strip().replace(u'\u2013',u'-')  # strip() is used to remove starting and trailing
		url_box =  div.find(attrs={'class': 'job-result-title'}).h2.a['href']
		url_root = 'http://irishjobs.ie' 
		url = url_root + url_box 
		salary_box = div.find(attrs={'class': 'salary'})
		salary = salary_box.text.strip().replace(u'\u2013',u'-').replace('000', 'K') 
		dates_box = div.find(attrs={'class': 'updated-time'})
		dates_ = dates_box.text.strip().replace(u'\u2013',u'-').replace('Updated ', '')
		dates = datetime.strptime((dates_.strip()),'%d/%m/%Y').strftime('%Y-%m-%d') 
		def desParse():
				quote_page = url
				req = urllib2.Request(quote_page, headers={ 'User-Agent': 'Mozilla/5.0' })
				page = urllib2.urlopen(req).read()
				soup = BeautifulSoup(page, 'html.parser')
				result = soup.find("div", {'class':'job-details'})
				return result
		descr = desParse()



		# irishjobs = {'role':role, 'company':company, 'location': location, 'salary': salary, 'dates':dates, 'url':url}
		loggit = "INSERT IGNORE INTO jobScraper (role, company, location, url, salary, dates, descr) VALUES (%s, %s, %s, %s, %s, %s, %s)"
		cur.execute(loggit, (role, company, location, url, salary, dates, descr))		
		db.commit()
		#pp = pprint.PrettyPrinter(indent=4)
		#pp.pprint(irishjobs)


jobbioParse()
irishjobsParse()
# stackOverflowParse()

db.close()
