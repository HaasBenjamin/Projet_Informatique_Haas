# Set all the necessary permissions to the local files.
find . -type d -exec setfacl -m d:u:$USER:rwx {} \;
find . -type d -exec setfacl -m d:u:200000:rwx {} \;
find . -type d -exec setfacl -m u:200000:rwx {} \;
find . -type f -exec setfacl -m u:200000:rw {} \;
find bin -type f -exec setfacl -m u:200000:rx {} \;
find docker 
find . -type d -exec setfacl -m d:u:200082:rx {} \;
find . -type d -exec setfacl -m u:200082:rx {} \;
find . -type f -exec setfacl -m u:200082:r {} \;
find public -type d -exec setfacl -m d:u:200101:rx {} \;
find public -type d -exec setfacl -m u:200101:rx {} \;
find public -type f -exec setfacl -m u:200101:r {} \;