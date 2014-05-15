<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$file = $argv[1];
$start = false;
$begin = false;
$first = false;

if (file_exists($file))
{
    foreach (file($file) as $line)
    {
        if (!$start && strpos(strtoupper($line), strtoupper("Scenario Outline")) >
                0)
        {
            $start = true;
            $name = mb_split(' ', str_replace("Scenario Outline:", "", $line));
            $filename = "";
            foreach ($name as $part)
                $filename .= ucfirst($part);
            print "    public function provider" . trim($filename) . "()\n";
            print "    {\n";
            print "        return array(\n";
        }
        elseif (!$begin && strpos(strtoupper($line), strtoupper("Examples:")))
        {
            $begin = true;
            $first = true;
        }
        elseif ($begin && $start)
        {
            if (strpos($line, "|") === false)
            {
                $begin = false;
                $start = false;
                print "        );\n";
                print "    }\n\n";
            }
            elseif ($first)
            {
                $first = false;
            }
            else
            {
                $params = "";
                foreach (mb_split("\|", $line) as $param)
                {
                    $param = trim($param);
                    if (strpos($param, ","))
                    {
                        $param = str_replace(" ", "", $param);
                        $params .= "array(";
                        foreach (mb_split(",", $param) as $part)
                            $params .= "'$part', ";
                        $params = substr($params, 0, strlen($params) - 2);
                        $params .= "), ";
                    }
                    elseif ($param !== "")
                        $params .= "'$param', ";
                }
                $params = substr($params, 0, strlen($params) - 2);
                print "            array($params),\n";
            }
        }
    }
    if ($start && $begin)
    {
        print "        );\n";
        print "    }\n\n";
    }
}
else
{
    print "Fiele $file does not exists.\n";
}