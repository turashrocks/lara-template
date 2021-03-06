<?php

namespace Botble\Widget;

use Botble\Widget\Contracts\ApplicationWrapperContract;
use Botble\Widget\Misc\ViewExpressionTrait;
use stdClass;

class WidgetGroup
{
    use ViewExpressionTrait;

    /**
     * The widget group name.
     *
     * @var string
     */
    protected $id;

    /**
     * @var mixed
     */
    protected $name;

    /**
     * @var mixed
     */
    protected $description;

    /**
     * The application wrapper.
     *
     * @var ApplicationWrapperContract
     */
    protected $app;

    /**
     * The array of widgets to display in this group.
     *
     * @var array
     */
    protected $widgets = [];

    /**
     * The position of a widget in this group.
     *
     * @var int
     */
    protected $position = 100;

    /**
     * The separator to display between widgets in the group.
     *
     * @var string
     */
    protected $separator = '';

    /**
     * The number of widgets in the group.
     *
     * @var int
     */
    protected $count = 0;

    /**
     * @param $args
     * @param ApplicationWrapperContract $app
     * @author Turash Chowdhury
     */
    public function __construct(array $args, ApplicationWrapperContract $app)
    {
        $this->id = $args['id'];
        $this->name = $args['name'];
        $this->description = array_get($args, 'description');

        $this->app = $app;
    }

    /**
     * Display all widgets from this group in correct order.
     *
     * @return string
     * @author Turash Chowdhury
     */
    public function display()
    {
        ksort($this->widgets);

        $output = '';
        $count = 0;
        foreach ($this->widgets as $position => $widgets) {
            foreach ($widgets as $widget) {
                $count++;
                $output .= $this->displayWidget($widget, $position);
                if ($this->count !== $count) {
                    $output .= $this->separator;
                }
            }
        }

        return $this->convertToViewExpression($output);
    }

    /**
     * Display a widget according to its type.
     *
     * @param $widget
     * @return mixed
     * @author Turash Chowdhury
     */
    protected function displayWidget($widget, $position)
    {
        $factory = $this->app->make($widget['type'] === 'sync' ? 'botble.widget' : 'botble.async-widget');

        $widget['arguments']['sidebar_id'] = $this->id;
        $widget['arguments']['position'] = $position;

        return call_user_func_array([$factory, 'run'], $widget['arguments']);
    }

    /**
     * Set widget position.
     *
     * @param int $position
     *
     * @return $this
     * @author Turash Chowdhury
     */
    public function position($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Add a widget to the group.
     * @author Turash Chowdhury
     */
    public function addWidget()
    {
        $this->addWidgetWithType('sync', func_get_args());
    }

    /**
     * Add a widget with a given type to the array.
     *
     * @param string $type
     * @param array $arguments
     * @author Turash Chowdhury
     */
    protected function addWidgetWithType($type, array $arguments = [])
    {
        if (!isset($this->widgets[$this->position])) {
            $this->widgets[$this->position] = [];
        }

        $this->widgets[$this->position][$arguments[0]] = [
            'arguments' => $arguments,
            'type' => $type,
        ];

        $this->count++;

        $this->resetPosition();
    }

    /**
     * Reset the position property back to the default.
     * So it does not affect the next widget.
     * @author Turash Chowdhury
     */
    protected function resetPosition()
    {
        $this->position = 100;
    }

    /**
     * Add an async widget to the group.
     * @author Turash Chowdhury
     */
    public function addAsyncWidget()
    {
        $this->addWidgetWithType('async', func_get_args());
    }

    /**
     * Getter for position.
     *
     * @return integer
     * @author Turash Chowdhury
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set a separator to display between widgets in the group.
     *
     * @param string $separator
     *
     * @return $this
     * @author Turash Chowdhury
     */
    public function setSeparator($separator)
    {
        $this->separator = $separator;

        return $this;
    }

    /**
     * Check if there are any widgets in the group.
     *
     * @return bool
     * @author Turash Chowdhury
     */
    public function any()
    {
        return !$this->isEmpty();
    }

    /**
     * Check if there are no widgets in the group.
     *
     * @return bool
     * @author Turash Chowdhury
     */
    public function isEmpty()
    {
        return empty($this->widgets);
    }

    /**
     * Count the number of widgets in this group.
     *
     * @return int
     * @author Turash Chowdhury
     */
    public function count()
    {
        $count = 0;
        foreach ($this->widgets as $widgets) {
            $count += count($widgets);
        }

        return $count;
    }

    /**
     * @return mixed|string
     * @author Turash Chowdhury
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     * @author Turash Chowdhury
     */
    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     * @author Turash Chowdhury
     */
    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return array
     * @author Turash Chowdhury
     */
    public function getWidgets()
    {
        $result = [];
        foreach ($this->widgets as $index => $item) {
            foreach (array_keys($item) as $key) {
                $obj = new stdClass();
                $obj->widget_id = $key;
                $obj->position = $index;
                $obj->sidebar_id = $this->id;
                $result[] = $obj;
            }
        }
        return $result;
    }
}
