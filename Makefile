PHPCMD=php --php-ini=php.ini

default:
	@echo 'Targets:'
	@echo '  test           Run all tests'
	@echo '  testdatetime   Test date/time functions'

test: testdatetime

testdatetime:
	@$(PHPCMD) testDateTime.php
