<?php
    final class MySQL {

        /**
         * @var MySQLi
         */
        private $link;

        public function __construct($hostname, $username, $password, $database) {

            $this->link = @new mysqli($hostname, $username, $password, $database);

            if (mysqli_connect_error()) {
                trigger_error('Error: Could not connect to database "' . $database . '"', E_USER_WARNING);
                die;
            }

            $this->link->set_charset('utf8');
            $this->link->query("SET SQL_MODE = ''");
        }

        public function query($sql) {

            $resource = $this->link->query($sql);

            if ($this->link->errno) {
                trigger_error('Error: ' . $this->link->error . '<br />Error No: ' . $this->link->errno . '<br />' . $sql);
                die;
            }

            if ($resource instanceof mysqli_result) {
                $i = 0;

                $data = array();

                while ($result = $resource->fetch_assoc()) {
                    $data[$i] = $result;

                    $i++;
                }

                $resource->free();

                $query = new stdClass();
                $query->row = isset($data[0]) ? $data[0] : array();
                $query->rows = $data;
                $query->num_rows = $i;

                unset($data);

                return $query;
            }

            return $resource;
        }

        public function escape($value) {

            return $this->link->real_escape_string($value);
        }

        public function countAffected() {

            return $this->link->affected_rows;
        }

        public function getLastId() {

            return $this->link->insert_id;
        }

        public function __destruct() {

            if (!mysqli_connect_error()) {
                $this->link->close();
            }
        }
    }
