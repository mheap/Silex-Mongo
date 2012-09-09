# installing mongo extension
curl -s http://pecl.php.net/get/mongo-1.2.9.tgz > mongo-1.2.9.tgz
tar -xzf mongo-1.2.9.tgz
sh -c "cd mongo-1.2.9 && phpize && ./configure && make && sudo make install"
echo "extension=mongo.so" >> `php --ini | grep "Loaded Configuration" | sed -e "s|.*:\s*||"`

wget silex-project.org/get/silex.phar

wget http://getcomposer.org/composer.phar
php composer.phar install --dev
