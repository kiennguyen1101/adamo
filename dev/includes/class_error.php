<?php

  class error extends Exception {

    protected $_Context = null;

    public function getContext() {
      return $this->_Context;
    }

    public function setContext($value) {
      $this->_Context = $value;
    }

    public function __construct($message, $code = 0, $file = '', $line = '', $context = '') {
      parent::__construct($message, $code);
    }

    public function __toString() {
      $this->dump_exception($this);
      return '';
    }

    private function dump_exception(error $ex) {
      $file = $ex->getFile();
      $line = $ex->getLine();

      if (file_exists($file)) {
        $lines = file($file);
      }
      ?>
      <style type="text/css">
        #Exception {
          width: 600px;
          margin: auto;
        }
        ul.code {
          border : inset 1px;
        }
        ul.code li {
          white-space: pre ;
          list-style-type : none;
          font-family : monospace;
        }
        ul.code li.line {
          color : red;
        }

        table.trace {
          width : 100%;
          border-collapse : collapse;
          border : solid 1px black;
        }
        table.thead tr {
          background : rgb(240,240,240);
        }
        table.trace tr.odd {
          background : white;
        }
        table.trace tr.even {
          background : rgb(250,250,250);
        }
        table.trace td {
          padding : 2px 4px 2px 4px;
        }
      </style>
      <div id='Exception'>
        <h1>Uncaught <?php echo get_class($ex); ?></h1>
        <h2><?php echo $ex->getMessage(); ?></h2>
        <p>
          An uncaught <?php echo get_class($ex); ?> was thrown on line <?php echo $line; ?> of file <?php echo basename($file); ?> that prevented further execution of this request.
        </p>
        <h2>Where it happened:</h2>
        <?php if (isset($lines)) : ?>
          <code><?php echo $file; ?></code>
          <ul class="code">
            <?php for ($i = $line - 3; $i < $line + 3; $i++) : ?>
              <?php if ($i > 0 && $i < count($lines)) : ?>
                <?php if ($i == $line - 1) : ?>
                  <li class="line"><?php echo str_replace("\n", "", $lines[$i]); ?></li>
                <?php else : ?>
                  <li><?php echo str_replace("\n", "", $lines[$i]); ?></li>
                <?php endif; ?>
              <?php endif; ?>
            <?php endfor; ?>
          </ul>
        <?php endif; ?>

        <?php if (is_array($ex->getTrace())) : ?>
          <h2>Stack trace:</h2>
          <table class="trace">
            <thead>
              <tr>
                <td>File</td>
                <td>Line</td>
                <td>Class</td>
                <td>Function</td>               
              </tr>
            </thead>
            <tbody>
              <?php foreach ($ex->getTrace() as $i => $trace) : ?>
                <tr class="<?php echo $i % 2 == 0 ? 'even' : 'odd'; ?>">
                  <td><?php echo isset($trace['file']) ? basename($trace['file']) : ''; ?></td>
                  <td><?php echo isset($trace['line']) ? $trace['line'] : ''; ?></td>
                  <td><?php echo isset($trace['class']) ? $trace['class'] : ''; ?></td>
                  <td><?php echo isset($trace['function']) ? $trace['function'] : ''; ?></td>                 
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        <?php else : ?>
          <pre><?php echo $ex->getTraceAsString(); ?></pre>
        <?php endif; ?>
      </div>
      <?php
    }

  }