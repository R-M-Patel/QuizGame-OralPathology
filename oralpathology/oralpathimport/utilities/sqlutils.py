import pymysql

dbhost = 'sis-teach-01.sis.pitt.edu'
dbport = 3306
dbuser = 'dentalgame'
dbpasswd = 'D3n!alGam@'
dbname = 'dentalgame'

def getConnection():
    conn = pymysql.connect(host=dbhost, port=dbport, user=dbuser, passwd=dbpasswd, db=dbname)
    return conn

def tableToDictionary(sql, key, value):
    conn = pymysql.connect(host=dbhost, port=dbport, user=dbuser, passwd=dbpasswd, db=dbname)
    cur = conn.cursor()
    cur.execute(sql)
    #print(cur.description)
    #print()

    dict = {}

    for row in cur:
        dict[row[key]] = row[value]

    cur.close()
    conn.close()

    return dict

def queryToDataset(sql, key):
    conn = pymysql.connect(host=dbhost, port=dbport, user=dbuser, passwd=dbpasswd, db=dbname)
    cur = conn.cursor()
    cur.execute(sql)

    dict = {}

    for row in cur:
        dict[row[key]] = row

    cur.close()
    conn.close()

    return dict

def queryToList(sql, list):
    conn = pymysql.connect(host=dbhost, port=dbport, user=dbuser, passwd=dbpasswd, db=dbname)
    cur = conn.cursor()
    cur.execute(sql)

    for row in cur:
        list.append(row[0])

    cur.close()
    conn.close()

    return list

def cleanSqlString(sqlField):
    #print(sqlField.replace("'", "\\'"))
    return sqlField.replace("'", "\\'")

def execMysqlQuery(sql, params):
    print(sql)
    #conn = pymysql.connect(host='localhost', port=3306, user='root', passwd='', db='ibd_import')
    conn = pymysql.connect(host=dbhost, port=dbport, user=dbuser, passwd=dbpasswd, db=dbname)
    conn.autocommit(1)
    cur = conn.cursor()
    cur.execute(sql, params)
    print(cur.description)
    cur.close()
    conn.close()

def recordExists(sql):
    print(sql)
    rowCount = 0
    conn = pymysql.connect(host=dbhost, port=dbport, user=dbuser, passwd=dbpasswd, db=dbname)
    cur = conn.cursor()
    cur.execute(sql)
    rowCount = cur.rowcount
    cur.close()
    conn.close()
    #print("ROW COUNT: " + str(rowCount))
    return True if rowCount > 0 else False

