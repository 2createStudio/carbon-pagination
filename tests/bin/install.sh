#!/usr/bin/env bash
# see https://github.com/wp-cli/wp-cli/blob/master/templates/install-wp-tests.sh

if [ $# -lt 3 ]; then
	echo "usage: $0 <db-name> <db-user> <db-pass> [db-host] [wp-version]"
	exit 1
fi

DB_NAME=$1
DB_USER=$2
DB_PASS=$3
DB_HOST=${4-localhost}
WP_VERSION=${5-latest}

BASEDIR="${PWD}"

# handle Windows drive paths
if [ "$(expr substr $(uname -s) 1 10)" == "MINGW32_NT" ]; then
	BASEDIR=$(echo $BASEDIR | sed -r 's/\/([a-zA-Z])\//\1:\//g')
fi

WP_TESTS_DIR="${BASEDIR}/tmp/wordpress-tests-lib"
WP_CORE_DIR="${BASEDIR}/tmp/wordpress/"

set -ex

install_wp() {
	mkdir -p $WP_CORE_DIR

	if [ $WP_VERSION == 'latest' ]; then
		local ARCHIVE_NAME='latest'
	else
		local ARCHIVE_NAME="wordpress-$WP_VERSION"
	fi

	curl https://wordpress.org/${ARCHIVE_NAME}.tar.gz --output /tmp/wordpress.tar.gz --silent

	tar --strip-components=1 -zxmf /tmp/wordpress.tar.gz -C $WP_CORE_DIR

	cp $BASEDIR/tests/misc/db.php $WP_CORE_DIR/wp-content/db.php
}

install_test_suite() {
	# portable in-place argument for both GNU sed and Mac OSX sed
	if [[ $(uname -s) == 'Darwin' ]]; then
		local ioption='-i .bak'
	else
		local ioption='-i'
	fi

	# set up testing suite
	mkdir -p $WP_TESTS_DIR
	cd $WP_TESTS_DIR
	svn co --quiet http://develop.svn.wordpress.org/trunk/tests/phpunit/includes/

	curl http://develop.svn.wordpress.org/trunk/wp-tests-config-sample.php --output wp-tests-config.php --silent

	# make sure colons are escaped (they might exist in Windows environments)
	WP_CORE_DIR=$(echo $WP_CORE_DIR | sed -r 's/:/\\:/g')

	sed $ioption "s:dirname( __FILE__ ) . '/src/':'$WP_CORE_DIR':" wp-tests-config.php 2> /dev/null
	sed $ioption "s/youremptytestdbnamehere/$DB_NAME/" wp-tests-config.php 2> /dev/null
	sed $ioption "s/yourusernamehere/$DB_USER/" wp-tests-config.php 2> /dev/null
	sed $ioption "s/yourpasswordhere/$DB_PASS/" wp-tests-config.php 2> /dev/null
	sed $ioption "s|localhost|${DB_HOST}|" wp-tests-config.php 2> /dev/null
	sed $ioption "s/Test Blog/Carbon Pagination Unit Tests/" wp-tests-config.php 2> /dev/null
}

install_wp
install_test_suite