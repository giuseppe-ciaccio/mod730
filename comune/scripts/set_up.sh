#!/usr/bin/env bash

# =============================================================================
#
# Author:       Artur Tolstenco
# Date:		    15/05/2013
# Description:	This script creates (or deletes) a specific mysql user and its 
#               two databses 
#               After the creation of databases this script populates both
#		        databases using the files present in the folder
#
# modif. 19/05/2014 Giuseppe Ciaccio
#
# =============================================================================

CURRENT_DIR=$(dirname "$0")
CLEAN_EXPECTED_ARGS=1
CREATE_EXPECTED_ARGS=2

PAR_CREATE='create'
PAR_CLEAN='clean'

PAR_ALL='all'
PAR_CREATE_USER='create_user'
PAR_POPULATION='populate'


DB_ROOT='root'
DB_ROOT_PWD='random85'
DB_HOST='localhost'

DB_USER='comune'
DB_USER_PWD='comune123'

# RS has two databases
RS_DB_NAME='comune_rs'
RS_DB_SCHEMA=$CURRENT_DIR'/rs.schema.mysql.sql'
RS_DB_DATA=$CURRENT_DIR'/rs.data.mysql.sql'
DATA_DB_NAME='comune_dati'
DATA_DB_SCHEMA=$CURRENT_DIR'/comune.schema.mysql.sql'
DATA_DB_DATA=$CURRENT_DIR'/comune.data.mysql.sql'



# PRIVATE FUNCTIONS ############################################################

# checks if the database population files exists
function check_files() {
    if [ ! -f $RS_DB_SCHEMA ] || [ ! -f $RS_DB_DATA ]; then
        echo 'The population files for "'$RS_DB_NAME'" database does not exist'
        exit 1
    fi

    if [ ! -f $DATA_DB_SCHEMA ] || [ ! -f $DATA_DB_DATA ]; then
        echo 'The population files for "'$DATA_DB_NAME'" database does not exist'
        exit 1
    fi
}

# checks if there was an error during execution of previous comand 
# and prints the $1 message
function check_error() {
    if [ $? -gt 0 ]; then
		echo $1
		exit 1
	fi
}

# creates a new mysql database user
function create_user() {
    bash $CURRENT_DIR/db_user.sh create $DB_ROOT $DB_ROOT_PWD $DB_HOST \
	                                     $DB_USER $DB_USER_PWD \
	                                     $RS_DB_NAME $DATA_DB_NAME
    check_error 'Error creating the new user or its databases...'
	echo 'The new user and the databases were created successfully'
}

# populates the DBs
function populate() {
    check_files
    php $CURRENT_DIR/load.mysql.php \
                      --rs_dbschema $RS_DB_SCHEMA \
                      --rs_dbdata $RS_DB_DATA \
                      --rs_withdata \
                      --data_dbschema $DATA_DB_SCHEMA \
                      --data_dbdata $DATA_DB_DATA \
                      --data_withdata
    check_error 'Error during the population of databases...'
    echo 'Databases populated successfully'
    
    echo
    echo '================================================================================'
    echo 'The database connection params must be handcoded into these places:'
    echo 'username = '$DB_USER' in application/configs/application.ini'
    echo 'password = '$DB_USER_PWD' in application/configs/application.ini'
    echo 'host = '$DB_HOST' in application/configs/application.ini'
    echo 'dbname = '$RS_DB_NAME' in application/configs/application.ini'
    echo 'dbname = '$DATA_DB_NAME' in application/modules/configs/config.ini'
    echo '================================================================================'
    echo
}

function all() {
    create_user
    populate
}

function create() {
    case $1 in
        $PAR_CREATE_USER)
            create_user
            ;;
        $PAR_POPULATION)
            populate
            ;;
        $PAR_ALL)
            all
            ;;
        *)
            echo 'Unrecognized parameter. Allowed parameters: '$PAR_ALL', '$PAR_CREATE_USER', '$PAR_POPULATION
            exit 1
    esac
}


function clean() {
    bash $CURRENT_DIR/db_user.sh delete $DB_ROOT $DB_ROOT_PWD $DB_HOST \
	                                     $DB_USER $DB_USER_PWD \
	                                     $RS_DB_NAME $DATA_DB_NAME
    check_error 'Error deleting the user or its databases...'
	echo 'The mysql user and the databases were deleted successfully'
}

################################################################################


# MAIN #########################################################################

if [ $# -lt $CLEAN_EXPECTED_ARGS ]; then
    echo 'Error: some arguments are missing'
    echo 'Usage: '$(basename $0)' '$PAR_CLEAN
    echo 'Usage: '$(basename $0)' '$PAR_CREATE\
                                   $PAR_ALL'|'$PAR_CREATE_USER'|'$PAR_POPULATION
        exit 1
fi

case $1 in
    $PAR_CLEAN)
        clean
        ;;

    $PAR_CREATE)
        if [ $# -ne $CREATE_EXPECTED_ARGS ]; then
	        echo 'Error: some arguments are missing'
	        echo 'Usage: '$(basename $0)' '$PAR_CREATE'|'$PAR_CLEAN\
	                                       $PAR_ALL'|'$PAR_CREATE_USER'|'$PAR_POPULATION
	        exit 1
        fi
        
        create $2
        ;;
    *)
        echo 'Unrecognized parameter. Allowed parameters: '$PAR_CREATE', '$PAR_CLEAN
esac

exit 0
