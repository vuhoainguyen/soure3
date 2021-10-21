<?php 
/*$bak = new DatabaseTool();
$bak->backup();*/
class DatabaseTool{
    private $handler;
    private $config = array(
        'host' => 'localhost',
        'port' => 3306,
        'user' => 'root',
        'password' => '',
        'database' => 'lk2',
        'charset' => 'utf-8',
        'target' => 'sql.sql'
    );
    private $tables = array();
    private $error;
    private $begin; //start time
    /**
    * Architecture method
    * @param array $config
    */
    public function __construct($config = array())
    {
        $this->begin = microtime(true);
        $config = is_array($config) ? $config : array();
        $this->config = array_merge($this->config, $config);
        // Start the PDO connection
        if (!$this->handler instanceof PDO) {
            try {
                $this->handler = new PDO("mysql:host={$this->config['host']}:{$this->config['port']};dbname={$this->config['database']}", $this->config['user'], $this->config['password']);
            } catch (PDOException $e) {
                $this->error = $e->getMessage();
                return false;
            } catch (Exception $e) {
                $this->error = $e->getMessage();
                return false;
            }
        }
    }
    /**
    * Backup
    * @param array $tables
    * @return bool
    */
    public function backup($tables = array())
    {
        // Array of stored table definition statements
        $ddl = array();
        // Array of stored data
        $data = array();
        $this->setTables($tables);
        if (!empty($this->tables)) {
            foreach ($this->tables as $table) {
                $ddl[] = $this->getDDL($table);
                $data[] = $this->getData($table);
            }
            // Start writing
            //var_dump($data);
            $this->writeToFile($this->tables, $ddl, $data);
        } else {
            $this->error = 'There is no table in the database!';
            return false;
        }
    }
    /**
    * Set the table to be backed up
    * @param array $tables
    */
    private function setTables($tables = array())
    {
        if (!empty($tables) && is_array($tables)) {
    // Backup specified table
            $this->tables = $tables;
        } else {
    // Backup all tables
            $this->tables = $this->getTables();
        }
    }
    /**
    * Inquire 
    * @param string $sql
    * @return mixed
    */
    private function query($sql = '')
    {
        $stmt = $this->handler->query($sql);
        $stmt->setFetchMode(PDO::FETCH_NUM);
        $list = $stmt->fetchAll();
        return $list;
    }
    /**
    * Get all the tables
    * @return array
    */
    private function getTables()
    {
        $sql = 'SHOW TABLES';
        $list = $this->query($sql);
        $tables = array();
        foreach ($list as $value) {
            $tables[] = $value[0];
        }
        return $tables;
    }
    /**
    * Get table definition statement
    * @param string $table
    * @return mixed
    */
    private function getDDL($table = '')
    {
        $sql = "SHOW CREATE TABLE `{$table}`";
        $ddl = $this->query($sql)[0][1] . ';';
        return $ddl;
    }
    /**
    * Get table data
    * @param string $table
    * @return mixed
    */
    private function getData($table = '')
    {
        $sql = "SHOW COLUMNS FROM `{$table}`";
        $list = $this->query($sql);
        //field
        $columns = '';
        // Need to return SQL
        $query = '';
        foreach ($list as $value) {
            $columns .= "`{$value[0]}`,";
        }
        $columns = substr($columns, 0, -1);
        $data = $this->query("SELECT * FROM `{$table}`");
        foreach ($data as $value) {
            $dataSql = '';
            foreach ($value as $v) {
                $dataSql .= "'{$v}',";
            }
            $dataSql = substr($dataSql, 0, -1);
            $query .= "INSERT INTO `{$table}` ({$columns}) VALUES ({$dataSql});\r\n";
        }
        return $query;
    }
    /**
    * Write to file
    * @param array $tables
    * @param array $ddl
    * @param array $data
    */
    private function writeToFile($tables = array(), $ddl = array(), $data = array())
    {
        $str = "/*\r\nMySQL Database Backup Tools\r\n";
        $str .= "Server:{$this->config['host']}:{$this->config['port']}\r\n";
        $str .= "Database:{$this->config['database']}\r\n";
        $str .= "Data:" . date('Y-m-d H:i:s', time()) . "\r\n*/\r\n";
        $str .= "SET FOREIGN_KEY_CHECKS=0;\r\n";
        $i = 0;
        foreach ($tables as $table) {
            $str .= "-- ----------------------------\r\n";
            $str .= "-- Table structure for {$table}\r\n";
            $str .= "-- ----------------------------\r\n";
            $str .= "DROP TABLE IF EXISTS `{$table}`;\r\n";
            $str .= $ddl[$i] . "\r\n";
            $str .= "-- ----------------------------\r\n";
            $str .= "-- Records of {$table}\r\n";
            $str .= "-- ----------------------------\r\n";
            $str .= $data[$i] . "\r\n";
            $i++;
        }
        echo file_put_contents($this->config['target'], $str) ? 'Backup succeeded! Spend time' . (microtime(true) - $this->begin) . 'ms' : 'Backup failed!';
    }
    /**
    * Error message
    * @return mixed
    */
    public function getError()
    {
        return $this->error;
    }
    public function restore($path = '')
    {
        if (!file_exists($path)) {
            $this->error('SQL file does not exist!');
            return false;
        } else {
            $sql = $this->parseSQL($path);
            try {
                $this->handler->exec($sql);
                echo 'Restore success! Spend time', (microtime(true) - $this->begin) . 'ms';
            } catch (PDOException $e) {
                $this->error = $e->getMessage();
                return false;
            }
        }
    }
    /**
    * Parse SQL file as an array of SQL statements
    * @param string $path
    * @return array|mixed|string
    */
    private function parseSQL($path = '')
    {
        $sql = file_get_contents($path);
        $sql = explode("\r\n", $sql);
        // Eliminate first -- comments
        $sql = array_filter($sql, function ($data) {
            if (empty($data) || preg_match('/^--.*/', $data)) {
                return false;
            } else {
                return true;
            }
        });
        $sql = implode('', $sql);
        //delete /**/comment
        $sql = preg_replace('/\/\*.*\*\//', '', $sql);
        return $sql;
    }
}
?>