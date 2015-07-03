#!/bin/bash

DIR=`pwd`
echo Run Unit Tests
cd $DIR/test/Unit && phpunit
echo Run Integration Tests
cd $DIR/test/WPIntegration && phpunit
cd $DIR