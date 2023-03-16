"""
Apache access logs formatting:
client IP, ?, user?, time request recieved, request summary (func, subdomain, HTTP protocol), success/status, sizeof response (bytes), referrer field, browser identifier
###:###:###, -, -, [##/LLL/####:##:##:## +1000], "GET /test /HTTP/1.0", 200, -, "-", "HomeNet/1.0" 

Regular Expressions:
client IP: smallest string between start and first whitespace
date recieved: anything between square brackets
browser: "quoted text" at end of string with the last (" ) before it
"""

import re

access_log_path = "/var/log/apache2/access_log"

access_logs = open(access_log_path).read()
access_list = re.findall(r"[^\t\n\r\f\v]+", access_logs)
access_list_components = [
    {'client IP': re.search(r'^.*?(?= )', access_item).group(0),
     'raw timestamp': re.search(r'\[.*\]', access_item).group(0),
     'hour': re.search(r'\[.*\]', access_item).group(0)[1:15][-2:],
     'date': re.search(r'\[.*\]', access_item).group(0)[1:15][:11],
     'browser ID': re.search(r'(?<=" )+".*"$', access_item).group(0)}
     for access_item in access_list if re.search('"http://clabsql.clamv.jacobs-university.de/~wblake/', access_item)]

# graph_timestamp_universal = dict([date]:dict([4-hour-interval]:[requests count]))
graph_timestamp_universal = {k1:v1 for (k1,v1) in list(zip(
                        list(dict.fromkeys([row1['date'] for row1 in access_list_components])),
                        [{k2:v2 for (k2,v2) in list(zip(
                            [0,1,2,3,4,5],
                            [0 for i in range(6)]
                        ))} for i in dict.fromkeys([row1['date'] for row1 in access_list_components])]
                    ))}

# graph_timestamp_browser = dict([date]:dict([4-hour-interval]:dict([browserID]:[requests count])))
graph_timestamp_browser = {k1:v1 for (k1,v1) in list(zip(
                        list(dict.fromkeys([row['date'] for row in access_list_components])),
                        [{k2:v2 for (k2,v2) in list(zip(
                            [0,1,2,3,4,5],
                            [{k3:v3 for (k3,v3) in list(zip(
                                list(dict.fromkeys([row['browser ID'] for row in access_list_components])),
                                [0 for i in dict.fromkeys([row['browser ID'] for row in access_list_components])]
                            ))} for i in range(6)]
                        ))} for i in dict.fromkeys([row['date'] for row in access_list_components])]
                    ))}

# graph_timestamp_ip = dict([date]:dict([4-hour-interval]:dict([clientIP]:[requests count])))
graph_timestamp_ip = {k1:v1 for (k1,v1) in list(zip(
                        list(dict.fromkeys([row['date'] for row in access_list_components])),
                        [{k2:v2 for (k2,v2) in list(zip(
                            [0,1,2,3,4,5],
                            [{k3:v3 for (k3,v3) in list(zip(
                                list(dict.fromkeys([row['client IP'] for row in access_list_components])),
                                [0 for i in dict.fromkeys([row['client IP'] for row in access_list_components])]
                            ))} for i in range(6)]
                        ))} for i in dict.fromkeys([row['date'] for row in access_list_components])]
                    ))}

for access_item in access_list_components:
    graph_timestamp_universal[access_item['date']][int(access_item['hour'])//4] += 1
    graph_timestamp_ip[access_item['date']][int(access_item['hour'])//4][access_item['client IP']] += 1
    graph_timestamp_browser[access_item['date']][int(access_item['hour'])//4][access_item['browser ID']] += 1



"""
for date,time_table in graph_timestamp_universal.items():
    for time,request in time_table.items():
        print(date)
print()
for date,time_table in graph_timestamp_universal.items():
    for time,request in time_table.items():
        print(time)
print()
for date,time_table in graph_timestamp_universal.items():
    for time,request in time_table.items():
        print(request)
print()
"""
"""
for date,time_table in graph_timestamp_ip.items():
    for time,ip_table in time_table.items():
        for ip,request in ip_table.items():
            print(date)
print()
for date,time_table in graph_timestamp_ip.items():
    for time,ip_table in time_table.items():
        for ip,request in ip_table.items():
            print(time)
print()
for date,time_table in graph_timestamp_ip.items():
    for time,ip_table in time_table.items():
        for ip,request in ip_table.items():
            print(ip)
print()
for date,time_table in graph_timestamp_ip.items():
    for time,ip_table in time_table.items():
        for ip,request in ip_table.items():
            print(request)
print()
"""
"""
for date,time_table in graph_timestamp_browser.items():
    for time,browser_table in time_table.items():
        for browser,request in browser_table.items():
            print(date)
print()
for date,time_table in graph_timestamp_browser.items():
    for time,browser_table in time_table.items():
        for browser,request in browser_table.items():
            print(time)
print()
for date,time_table in graph_timestamp_browser.items():
    for time,browser_table in time_table.items():
        for browser,request in browser_table.items():
            print(browser)
print()
for date,time_table in graph_timestamp_browser.items():
    for time,browser_table in time_table.items():
        for browser,request in browser_table.items():
            print(request)
print()
"""

'''
log_file = open("logs.csv",'w')
log_file.write("ip,date,browser\n")
for components_tuple in access_list_components:
    #log = components_tuple[0] + ',' + components_tuple[1] + ',' + components_tuple[2]+ '\n'
    #log_file.write(log)
    pass
log_file.close()
'''