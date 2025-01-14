# Test technique Humans Connexion
PHP 8<br/>
Symfony 7<br/>
Kendo Ui<br/>

## Requirements
* docker
* make

## Installation
```
make install
```

add a back.local entry in your host file
```
127.0.0.1   back.local
```

## Usage
you can go to http://back.local to see the article grid

All commands (new record, edit, delete) must be validated by a save command. 
You can cancel the commands pull by pressing the 'cancel' button

## CI
you can run the ci locally outside the back container
```
make check
```
and fix errors
```
make fix
```

## Test
you can run the tests

#### outside the container: 
```
make test
```
#### inside the back container: 
```
bin/phpunit
```
