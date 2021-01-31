# concurrent-php script

### This script runs as many time you want concurrently with the query string count=[number]

As PHP was new for me this exercise was quite hard since the documentation for PHP language was not the best as other programming languages.

I did not had PHP on my computer so firstly I’ve setup a virtual machine with Ubuntu, afterwards I installed php and apache2 web server and setup the apache2 server to work with my localhost address.

Reading the documentation, I have found this function file_get_contents to fetch the data from the API but later I found it’s a blocking function which means the execution of this function blocks another lines of code to execute until it finished the fetch. In our case the https://postman-echo.com/delay/3 returns response to the call after 3 second and hence blocks for 3 seconds until we receive the response.

I tried to solve this by implementing a multithreaded with external library called pthereds but then read that PHP does not support multithread natively, and PHP is a high-level scripting language and the original purpose of it was to serve stateless HTTP requests. Trying to do this we will need to use an external library like pthreads. Trying to implement this approach with pthreads concluded that pthreads project halted and not compiling on php 7.4.x.

And then I came across Forking the program with pcntl_fork I failed in this execution and got lost in all the child process and left me with confusion.

I came across curl requests and using the multi-curl function and for some funny reason had no success with it, I blame the late hour on the day for not succeeding.
Trying to do multi-curl again after a good night sleep and with the suggestion from someone I finally understood what my mistake was in doing this approach and solve this puzzle.

To solve this exercise we have 3 approaches we can solve this:

##	Multi-Thread 

Pros:

•	You can split the work on multiple threads each performing small task at the same time

•	The work doesn’t have to complete sequentially.
      
Cons:

•	Threads are part of the same process and will usually share the same memory & file resources. Not properly accounted for, this can lead to unexpected results like race conditions or deadlocks. In PHP however, this will not be the case: memory is not shared, though it is still possible to affect data in another thread.

##	Multi-Process

Pros:

•	independent application runs.

Cons:

•	will not share any memory or handles, making it much harder to actually sync data between them Distributed.

•	Needs to track the children and parents relationships.
In our case this is not a cons since we only fetching the same API data and displaying the results.

##	Distributed Parallel Processing

Pros:

•	Using distributed libraries and frameworks to distribute the job on multiply server and not being depend only on one machine CPU and memory.

Cons:

•	Out of the scope of the solution of this exercise.

## Terminal output from the script
```
$ time curl concurrent.dev/index.php?count=10
[{"delay":"3"},{"delay":"3"},{"delay":"3"},{"delay":"3"},{"delay":"3"},{"delay":"3"},{"delay":"3"},{"delay":"3"},{"delay":"3"},{"delay":"3"}]
real	0m4.147s
user	0m0.008s
sys	0m0.000s
```
### Grab the php file and try it out.
