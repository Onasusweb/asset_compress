<?php
namespace AssetCompress\Filter;

use AssetCompress\AssetFilter;
use AssetCompress\Filter\CssDependencyTrait;

/**
 * Pre-processing filter that adds support for SCSS files.
 *
 * Requires ruby and sass rubygem to be installed
 *
 * @see http://sass-lang.com/
 */
class ScssFilter extends AssetFilter
{
    use CssDependencyTrait;

    protected $_settings = array(
        'ext' => '.scss',
        'sass' => '/usr/bin/sass',
        'path' => '/usr/bin',
        'paths' => [],
    );

    /**
     * Runs SCSS compiler against any files that match the configured extension.
     *
     * @param string $filename The name of the input file.
     * @param string $input The content of the file.
     * @return string
     */
    public function input($filename, $input)
    {
        if (substr($filename, strlen($this->_settings['ext']) * -1) !== $this->_settings['ext']) {
            return $input;
        }
        $filename = preg_replace('/ /', '\\ ', $filename);
        $bin = $this->_settings['sass'] . ' ' . $filename;
        $return = $this->_runCmd($bin, '', array('PATH' => $this->_settings['path']));
        return $return;
    }
}