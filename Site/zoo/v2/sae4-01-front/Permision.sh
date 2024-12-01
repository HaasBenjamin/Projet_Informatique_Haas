find . -type d -exec setfacl -m d:u:$USER:rwx {} \;

find . -type d -exec setfacl -m d:u:200000:rwx {} \;
find . -type d -exec setfacl -m u:200000:rwx {} \;
find . -type f -exec setfacl -m u:200000:rw {} \;

find . -type d -exec setfacl -m d:u:200001:rx {} \;
find . -type d -exec setfacl -m u:200001:rx {} \;
find . -type f -exec setfacl -m u:200001:r {} \;

find . -type d -exec setfacl -m d:u:200082:rx {} \;
find . -type d -exec setfacl -m u:200082:rx {} \;
find . -type f -exec setfacl -m u:200082:r {} \;

find public -type d -exec setfacl -m d:u:200101:rx {} \;
find public -type d -exec setfacl -m u:200101:rx {} \;
find public -type f -exec setfacl -m u:200101:r {} \;