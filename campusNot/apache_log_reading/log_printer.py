log_path = "/var/log/apache2/access_log"
#log_path = "/xampp/apache/logs/access.log"
#log_path = "/var/log/apache2/error_log"
#log_path = "/xampp/apache/logs/error.log"

logs = open(log_path).read()
print(logs)