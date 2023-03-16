"""
client IP, date, error info
"""

import re

error_log_path = "/var/log/apache2/error_log"

error_logs = open(error_log_path).read()
error_list = re.findall(r"[^\t\n\r\f\v]+", error_logs)
error_list_components = [
    {'client IP': re.search(r'(\[.*?\]) (\[.*?\]) (\[.*?\]) (\[.*?\]) (.*)', error_item).group(4)[8:-7],
     'raw timestamp': re.search(r'(\[.*?\]) (\[.*?\]) (\[.*?\]) (\[.*?\]) (.*)', error_item).group(1),
     'hour': re.search(r'(\[.*?\]) (\[.*?\]) (\[.*?\]) (\[.*?\]) (.*)', error_item).group(1)[5:14][-2:],
     'date': re.search(r'(\[.*?\]) (\[.*?\]) (\[.*?\]) (\[.*?\]) (.*)', error_item).group(1)[5:14][:7],
     'error': re.search(r'(\[.*?\]) (\[.*?\]) (\[.*?\]) (\[.*?\]) (.*)', error_item).group(2),
     'Error info': re.search(r'(\[.*?\]) (\[.*?\]) (\[.*?\]) (\[.*?\]) (.*)', error_item).group(5)}
     for error_item in error_list if (re.search('http://clabsql.clamv.jacobs-university.de/~wblake', error_item) and re.search(':error]', error_item))]

# graph_timestamp_universal = dict([date]:dict([4-hour-interval]:[errors count]))
graph_timestamp_universal = {k1:v1 for (k1,v1) in list(zip(
                        list(dict.fromkeys([row1['date'] for row1 in error_list_components])),
                        [{k2:v2 for (k2,v2) in list(zip(
                            [0,1,2,3,4,5],
                            [0 for i in range(6)]
                        ))} for i in dict.fromkeys([row1['date'] for row1 in error_list_components])]
                    ))}

# graph_timestamp_error = dict([date]:dict([4-hour-interval]:dict([error]:[requests count])))
graph_timestamp_error = {k1:v1 for (k1,v1) in list(zip(
                        list(dict.fromkeys([row['date'] for row in error_list_components])),
                        [{k2:v2 for (k2,v2) in list(zip(
                            [0,1,2,3,4,5],
                            [{k3:v3 for (k3,v3) in list(zip(
                                list(dict.fromkeys([row['error'] for row in error_list_components])),
                                [0 for i in dict.fromkeys([row['error'] for row in error_list_components])]
                            ))} for i in range(6)]
                        ))} for i in dict.fromkeys([row['date'] for row in error_list_components])]
                    ))}

# graph_timestamp_ip = dict([date]:dict([4-hour-interval]:dict([clientIP]:[errors count])))
graph_timestamp_ip = {k1:v1 for (k1,v1) in list(zip(
                        list(dict.fromkeys([row['date'] for row in error_list_components])),
                        [{k2:v2 for (k2,v2) in list(zip(
                            [0,1,2,3,4,5],
                            [{k3:v3 for (k3,v3) in list(zip(
                                list(dict.fromkeys([row['client IP'] for row in error_list_components])),
                                [0 for i in dict.fromkeys([row['client IP'] for row in error_list_components])]
                            ))} for i in range(6)]
                        ))} for i in dict.fromkeys([row['date'] for row in error_list_components])]
                    ))}

for error_item in error_list_components:
    graph_timestamp_universal[error_item['date']][int(error_item['hour'])//4] += 1
    graph_timestamp_ip[error_item['date']][int(error_item['hour'])//4][error_item['client IP']] += 1
    graph_timestamp_error[error_item['date']][int(error_item['hour'])//4][error_item['error']] += 1


"""
for date,time_table in graph_timestamp_universal.items():
    for time,error in time_table.items():
        print(date)
print()
for date,time_table in graph_timestamp_universal.items():
    for time,error in time_table.items():
        print(time)
print()
for date,time_table in graph_timestamp_universal.items():
    for time,error in time_table.items():
        print(error)
print()
"""
"""
for date,time_table in graph_timestamp_ip.items():
    for time,ip_table in time_table.items():
        for ip,error in ip_table.items():
            print(date)
print()
for date,time_table in graph_timestamp_ip.items():
    for time,ip_table in time_table.items():
        for ip,error in ip_table.items():
            print(time)
print()
for date,time_table in graph_timestamp_ip.items():
    for time,ip_table in time_table.items():
        for ip,error in ip_table.items():
            print(ip)
print()
for date,time_table in graph_timestamp_ip.items():
    for time,ip_table in time_table.items():
        for ip,error in ip_table.items():
            print(error)
print()
"""
"""
for date,time_table in graph_timestamp_error.items():
    for time,error_table in time_table.items():
        for errortype,error in error_table.items():
            print(date)
print()
for date,time_table in graph_timestamp_error.items():
    for time,error_table in time_table.items():
        for errortype,error in error_table.items():
            print(time)
print()
for date,time_table in graph_timestamp_error.items():
    for time,error_table in time_table.items():
        for errortype,error in error_table.items():
            print(errortype)
print()
for date,time_table in graph_timestamp_error.items():
    for time,error_table in time_table.items():
        for errortype,error in error_table.items():
            print(error)
print()
"""