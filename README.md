# RectoVerso2PDFsIn1

Script wrote in order to assemble 2 PDFs in 1 my Scanner's document feeder doesn't support recto verso scanning...

I wrote the script on Mac Os X Mojave 10.14.2

Prerequisites :  

 1. PhP 7.2 that supports ioncube  
 2. A license (even trial) of SetaPDF-Core    

How to use : 

 1. clone and setup git Repository  
 2. First launch  
 3. Examples. 

# Prerequisites

##1. PhP 7.2 that supports ioncube  
#### 1.1 Check your php config

```
$ php -v
PHP 7.1.19 (cli) (built: Aug 17 2018 20:10:18) ( NTS )
Copyright (c) 1997-2018 The PHP Group
Zend Engine v3.1.0, Copyright (c) 1998-2018 Zend Technologies
```

If you have the above, without ioncube mentionned, which is not good, please jump to `1.2 Compile and configure PhP 7.2` 

Expected output is has below :  

```
$ php -c php.ini -v
PHP 7.2.11 (cli) (built: Mar 27 2019 23:01:35) ( NTS )
Copyright (c) 1997-2018 The PHP Group
Zend Engine v3.2.0, Copyright (c) 1998-2018 Zend Technologies
    with the ionCube PHP Loader v10.3.2, Copyright (c) 2002-2018, by ionCube Ltd.
```

If you have the above please proceed to `xx Download and run the script`

#### 1.2 Compile and configure PhP 7.2

in order to leverage ioncube I needed to compile php and openssl myself 

##### 1.2.1 Prepare and compile OpenSSL (this is an extra not mandatory):
great article explains it all here : https://mac-dev-env.patrickbougie.com/openssl/  
Not mandatory if you don't want it think of removing `--with-openssl=/usr/local/openssl`, when you compile it during next step below


##### 1.2.2 Prepare and compile PhP : 
Follow this instructions : https://mac-dev-env.patrickbougie.com/php/  

You can follow instruction from begining and stop at `PHP Configuration` if as me you only are leveraging command line.

By the way my configure line is a bit different, I removed apxs since I only do command line, look below :

```
$./configure  
  --prefix=/usr/local/mac-dev-env/php-7.2.11  \
  --with-config-file-path=/usr/local/mac-dev-env/php-7.2.11/etc \  
  --enable-bcmath \
  --enable-mbstring \
  --enable-sockets \
  --enable-zip \
  --with-bz2 \
  --with-curl \
  --with-gd \
  --with-imap-ssl \
  --with-jpeg-dir=/usr/local/libjpeg \
  --with-mysqli \
  --with-pear \
  --with-pdo-mysql \
  --with-png-dir=/usr/local/libpng \
  --with-openssl=/usr/local/openssl \
  --with-xmlrpc \
  --with-xsl \
  --with-zlib
```

Once article followed you should have php 7.2 installed in mac-dev-env and a symbolic link to it in /usr/local  

```
ls -l /usr/local/mac-dev-env/php-7.2.11/
total 0
drwxr-xr-x  12 enola  staff  384 Mar 28 06:05 bin
drwxr-xr-x   4 enola  staff  128 Mar 28 06:19 etc
drwxr-xr-x   3 enola  staff   96 Mar 28 06:05 include
drwxr-xr-x   3 enola  staff   96 Mar 28 06:05 lib
drwxr-xr-x   3 enola  staff   96 Mar 28 06:05 php
drwxr-xr-x   4 enola  staff  128 Mar 28 06:05 var
```

##### 1.2.3 make php loads ioncube 


a. Download Ioncube by going to : http://www.ioncube.com/loaders.php in my this example platform is `OS X (64 bits)`

b. Once downloaded extract the archive, in my case :

```
$ cd ~/Downloads
$ unzip ioncube_loaders_dar_x86-64.zip
Archive:  ioncube_loaders_dar_x86-64.zip
   creating: ioncube/
  inflating: ioncube/ioncube_loader_dar_5.4.so  
  inflating: ioncube/ioncube_loader_dar_4.4.so  
  inflating: ioncube/ioncube_loader_dar_5.1.so  
  inflating: ioncube/ioncube_loader_dar_7.2_ts.so  
  inflating: ioncube/ioncube_loader_dar_5.1_ts.so  
  inflating: ioncube/ioncube_loader_dar_7.0_ts.so  
  inflating: ioncube/loader-wizard.php  
  inflating: ioncube/ioncube_loader_dar_5.6.so  
  inflating: ioncube/LICENSE.txt     
  inflating: ioncube/ioncube_loader_dar_7.1_ts.so  
  inflating: ioncube/ioncube_loader_dar_5.5.so  
  inflating: ioncube/USER-GUIDE.pdf  
  inflating: ioncube/ioncube_loader_dar_5.2_ts.so  
  inflating: ioncube/ioncube_loader_dar_4.4_ts.so  
  inflating: ioncube/ioncube_loader_dar_5.3_ts.so  
  inflating: ioncube/ioncube_loader_dar_5.2.so  
  inflating: ioncube/ioncube_loader_dar_7.3.so  
  inflating: ioncube/ioncube_loader_dar_7.3_ts.so  
  inflating: ioncube/ioncube_loader_dar_7.1.so  
  inflating: ioncube/ioncube_loader_dar_7.2.so  
  inflating: ioncube/ioncube_loader_dar_5.4_ts.so  
  inflating: ioncube/USER-GUIDE.txt  
  inflating: ioncube/ioncube_loader_dar_5.3.so  
  inflating: ioncube/README.txt      
  inflating: ioncube/ioncube_loader_dar_5.5_ts.so  
  inflating: ioncube/ioncube_loader_dar_7.0.so  
  inflating: ioncube/ioncube_loader_dar_5.6_ts.so 
``` 

c. Create a folder named ioncube in /usr/local and copy the right lib

```
$ sudo mkdir /usr/local/ioncube
$ sudo cp ~/Downloads/ioncube/ioncube_loader_dar_7.2.so /usr/local/ioncube/
$ ls -l /usr/local/ioncube
```
```
-rw-r--r--@ 1 root  wheel  1466264 Mar 27 08:57 ioncube_loader_dar_7.2.so
```

d. Tell PhP to load ioncube when invoked

Open /usr/local/php/etc/php.ini
Add this line :
`zend_extension="/usr/local/ioncube/ioncube_loader_dar_7.2.so" `  
Save and Close

You can also find an example with this line included in `php.ini.example`,  
this is only a sample took after compilation (0 optimization at all)

e. Verify PhP loads ioncube extension

```
$/usr/local/php/bin/php -c /usr/local/php/etc/php.ini -v
```
```
PHP 7.2.11 (cli) (built: Mar 27 2019 23:01:35) ( NTS )  
Copyright (c) 1997-2018 The PHP Group  
Zend Engine v3.2.0, Copyright (c) 1998-2018 Zend Technologies  
    with the ionCube PHP Loader v10.3.2, Copyright (c) 2002-2018, by ionCube Ltd.    
```

##2. A license (even trial) of SetaPDF-Core
As told earlier we are using setaPDF-Core to assemble our PDF, this lib is made available by Setassign which isn't free unfortunately. Nevertheless you can ask for a 14 days trial to make up your mind. Good news is that we only need the core peace which is the less expensive one.

#### 2.1 Create an account at setassign
a. Go To https://www.setasign.com/register  
b. Create an account  
c. Once done go to https://www.setasign.com/ and login  
d. Go to : https://www.setasign.com/products/setapdf-core/evaluate/  
e. Click on "Request evaluation License"  
f. Go to : https://www.setasign.com/products/setapdf-core/downloads/  


# How to use

##1. Clone and setup Git repo. `rectoverso2pdfsin1` 
#### 1.1 Download the git project
a. Go to the folder where you wish to download 

```
$ cd ~/Downloads
```
b. Clone the project

```
$ git clone git@github.com:enoola/RectoVerso2PDFsIn1.git
$ cd RectoVerso2PDFsIn1
```
c. Install the dependencies with composer

```
$ /usr/local/php/bin/php composer install

Deprecation warning: require.setasign/eval/setapdf-core/ioncube/php7.1 is invalid, it should have a vendor name, a forward slash, and a package name. The vendor and package name can be words separated by -, . or _. The complete name should match "[a-z0-9]([_.-]?[a-z0-9]+)*/[a-z0-9]([_.-]?[a-z0-9]+)*". Make sure you fix this as Composer 2.0 will error.
Loading composer repositories with package information
Installing dependencies (including require-dev) from lock file
Package operations: 7 installs, 0 updates, 0 removals
  - Installing setasign/eval/setapdf-core/ioncube (1.0.2216295): Loading from cache
  - Installing setasign/eval/setapdf-core/ioncube/php7.1 (2.30.0.1317): Loading from cache
  - Installing symfony/polyfill-mbstring (v1.11.0): Loading from cache
  - Installing symfony/contracts (v1.0.2): Loading from cache
  - Installing symfony/console (v4.2.4): Loading from cache
  - Installing symfony/polyfill-ctype (v1.11.0): Loading from cache
  - Installing symfony/yaml (v4.2.4): Loading from cache
symfony/contracts suggests installing psr/cache (When using the Cache contracts)
symfony/contracts suggests installing psr/container (When using the Service contracts)
symfony/contracts suggests installing symfony/cache-contracts-implementation
symfony/contracts suggests installing symfony/service-contracts-implementation
symfony/contracts suggests installing symfony/translation-contracts-implementation
symfony/console suggests installing psr/log (For using the console logger)
symfony/console suggests installing symfony/event-dispatcher
symfony/console suggests installing symfony/lock
symfony/console suggests installing symfony/process
Generating autoload files
```




## 2. First Launch

We will invoke our script and see help

```
$ /usr/local/php/bin/php -c php.ini.example console.php rectoverso2pdfsin1 -h
```
```
Description:
  Fusion 2 PDFs in 1 My Scanner's document feeder doesn't support recto verso scanning...

Usage:
  rectoverso2pdfsin1 [options] [--] <pdfrecto> <pdfverso> <pdfoutput> [<numpageverso>]

Arguments:
  pdfrecto                  pdf recto path.
  pdfverso                  pdf verso path.
  pdfoutput                 output PDF file name.
  numpageverso              number of pages on verso to take and add.

Options:
      --forcerewriteoutput  rewrite output file if exists, 0 by default.
  -h, --help                Display this help message
  -q, --quiet               Do not output any message
  -V, --version             Display this application version
      --ansi                Force ANSI output
      --no-ansi             Disable ANSI output
  -n, --no-interaction      Do not ask any interactive question
  -v|vv|vvv, --verbose      Increase the verbosity of messages: 1 for normal output, 2 for more verbose output and 3 for debug
```

## 3. Examples

In order to fast try we have some files :
`example_recto.pdf`, `example_verso.pdf` : which represents a 3 pages document  
scanned, each pages contain a simple 'Page x' at the top, x being number of the page. 

when I scan a 3 pages document it looks like this

| recto      | verso       |
| ---------- | ----------- |
| Page 1     | Page 4      |
| Page 2     | Page 3      |

Ultimately we want a PDF with 3 pages, so expected output is as below :

| output     |
| ---------- |
| Page 1     |
| Page 2     |
| Page 3     |


#### 3.1 Assemble 2 PDFs

##### 3.1.1 Fastest way
We will assemble our examples with the minimum argument possible with only `-v` for it to be verbose
I assume you are in the folder where you downloaded this project

```
$ /usr/local/php/bin/php -c php.ini.example console.php rectoverso2pdfsin1 \
 example_recto.pdf example_verso.pdf example_output.pdf -v
```

```
Number of pages on recto document   : 2
Number of pages to append from verso : 2
-> page recto number : 1
-> page verso : 2
-> page recto number : 2
-> page verso : 1
File example_output.pdf created.
```

Now open the resulting file, it will look like the below :

| example_output.pdf     |
| ---------------------- |
| Page 1     				  |
| Page 2     				  |
| Page 3     				  |
| Page 4 (completely blank)     |


Well not bad nevertheless we would like a 3 pages PDF, see below.

##### 3.1.2 Define number of pages to take on verso 

We will tell `rectoverso2pdfsin1` to only take 1 page on the verso (where the is two) this is achieved by puting the number of page to keep on recto after output filename

```
$ /usr/local/php/bin/php -c php.ini.example console.php rectoverso2pdfsin1 -v example_recto.pdf example_verso.pdf example_output.pdf 1
```
```
Output PDF exists already add option --forcerewriteoutput.
```

No worries this is because the output file you have given already exists.

##### 3.1.3 Forcerewrite output file if already exists

Below is how to force rewriting the output file if exists already.

```
$ /usr/local/php/bin/php -c php.ini.example console.php \
rectoverso2pdfsin1 -v example_recto.pdf example_verso.pdf example_output.pdf 1 --forcerewriteoutput
```

```
Will remove existing output file : example_output.pdf.
Number of pages on recto document   : 2
Number of pages to append from verso : 1
-> page recto number : 1
-> page verso : 2
-> page recto number : 2
File example_output.pdf created.
```

Now open the resulting file, it will look like the below :

| example_output.pdf     |
| ---------------------- |
| Page 1     				  |
| Page 2     				  |
| Page 3     				  |



I hope this is enough if you have any question or request or see errors just reach out :)



