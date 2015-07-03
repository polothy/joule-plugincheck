# JoulePluginCheck Coding Standard
## Disallow Manual Inclusion of jQuery
Including jQuery and associated libraries manually can cause issues. The versions bundled with Moodle should be used wherever possible.
## Disallow Deprecated PARAM_ Constants
The PARAM_ constants within Moodle are used for cleaning parameters. Deprecated constants should not be used.
## Warn About mdl_ prefix in SQL Queries
Using the hard coded `mdl_` prefix in SQL queries can cause undesired results. This sniff looks for the
    use of the prefix in strings. As such some false positives may occur, however it is expected that these
    will be minimal.
  <table>
   <tr>
    <th>Valid: A SQL query without mdl_ prefix.</th>
    <th>Invalid: A SQL query with the mdl_ prefix.</th>
   </tr>
   <tr>
<td>

    $sql = 'SELECT * FROM {user} WHERE id = ?';

</td>
<td>

    $sql = 'SELECT * FROM mdl_user WHERE id = ?';

</td>
   </tr>
  </table>
## Warn About Raw SQL Functions
Moodle provides a number of helper functions for accing the database, including some functions that allow
    the use of raw SQL. This can be problematic if the SQL is complext, inefficient, or includes parameters
    correctly. For this reason, this sniff warns about the use of these functions for further investigation.
## Disallow the use of cURL
Moodle comes with its own classes for accessing resources via cURL. These should be used in preference to using cURL directly, as it allows optimisations
    to be implemented in one place only. For example limiting timeouts to meet page generation time (PGT) goals, or accessing resources via proxy servers.
## Disallow Deprecated Moodle Functions
Moodle functions that are deprecated produce warnings. These warnings provide a poor user experience, and spam logs.
    Therefore any deprecated functions must be replaced with their updated alternatives.
## Disallow Filesystem Related Moodle Functions
In a multi-node environment Moodle plugin code cannot create a temporary file, and expect it to be avaiable on a subsequent request.
    Code using these Moodle functions be checked to ensure that temporary file creation is limited, and is only used in servicing the current request.
## Warn About the Use of Paths
Code that access files in the {{$CFG-&gt;dataroot}} and {{$CFG-&gt;tempdir}} directories must be checked to ensure it is not
    creating or accessing files that it should not. Additionally the code should not be creating files and expecting them to
    be available on subsequent requests.
## Disallow Multiple Namespace Declarations
The Moodle Style Guide prohibits more than one namespace declaration per file.
    This sniff enforces that rule. More information is available in the [Moodle style guide](https://docs.moodle.org/dev/Coding_style#Namespaces).
## Warn about classes instantiation without namespaces
Warn about attempts to instantiate classes that require namespaces.
  <table>
   <tr>
    <th>Valid: Instantiation with namespaces</th>
    <th>Invalid: Instantiation without namespaces</th>
   </tr>
   <tr>
<td>

    namespace pies;
    
    use \pies\plates\Wedgwood;
    use \pies\cutlery\Spoon as Spork;
    
    class apple {
    
        protected $createdon;
        protected $plate;
        protexted $cutlery;
    
        function __construct(){
             $this->createdon = new DateTime();
             $this->plate = new Wedgwood();
             $this->cutlery = new Spork();
        }
    }

</td>
<td>

    namespace pies;
    
    class apple {
    
        protected $createdon;
        protected $plate;
        protexted $cutlery;
    
        function __construct(){
             $this->createdon = new DateTime(); // <-- this should be new \DateTime();
             $this->plate = new Wedgwood();
             $this->cutlery = new Spork();
        }
    }

</td>
   </tr>
  </table>
## Warn about PHP close tag at end of file
If the PHP close tag '?&gt;' is detected at the end of a file, a warning is raised.
If the PHP close tag is detected at the end of a file, and there is whitespace after it, an error is raised.

This is because the PHP close tag at the end of the file can produce underisable output.
## Disallow Direct Access to Global Request Variables
Moodle provide core functionality to clean parameters. Not using these functions can be a serious security concern. Therefore code
    cannot access the global request variables directly.
## Byte Order Marks
Byte Order Marks that may corrupt your application should not be used.  These include 0xefbbbf (UTF-8), 0xfeff (UTF-16 BE) and 0xfffe (UTF-16 LE).
## Line Endings
Unix-style line endings are preferred (&quot;\n&quot; instead of &quot;\r\n&quot;).
## Deprecated Functions
Deprecated functions should not be used.
  <table>
   <tr>
    <th>Valid: A non-deprecated function is used.</th>
    <th>Invalid: A deprecated function is used.</th>
   </tr>
   <tr>
<td>

    $foo = explode('a', $bar);

</td>
<td>

    $foo = split('a', $bar);

</td>
   </tr>
  </table>
## PHP Code Tags
Always use &lt;?php ?&gt; to delimit PHP code, not the &lt;? ?&gt; shorthand. This is the most portable way to include PHP code on differing operating systems and setups.
## Silenced Errors
Suppressing Errors is not allowed.
  <table>
   <tr>
    <th>Valid: isset() is used to verify that a variable exists before trying to use it.</th>
    <th>Invalid: Errors are suppressed.</th>
   </tr>
   <tr>
<td>

    if (isset($foo) && $foo) {
        echo "Hello\n";
    }

</td>
<td>

    if (@$foo) {
        echo "Hello\n";
    }

</td>
   </tr>
  </table>
Documentation generated on Fri, 03 Jul 2015 15:50:16 +0930 by [PHP_CodeSniffer 2.3.3](https://github.com/squizlabs/PHP_CodeSniffer)