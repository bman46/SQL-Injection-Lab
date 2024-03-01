echo "SQL Injection Lab Setup"
re='^[0-9]$'
if ! [[ $VERSION =~ $re ]] ; then
   echo "error: argument must be a number 0-9" >&2; exit 1
fi
cp -R /mods/$VERSION/* /var/www/html/
cd /var/www/html
bash apache2-foreground