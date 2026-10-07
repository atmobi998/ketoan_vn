<?php
declare(strict_types=1);

namespace CrudJsonApi\Listener;

use Cake\Datasource\Paging\PaginatedInterface;
use Cake\Event\EventInterface;
use Cake\Routing\Router;
use Crud\Listener\ApiPaginationListener as BaseListener;

/**
 * When loaded Crud API Pagination Listener will include
 * pagination information in the response
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 */
class PaginationListener extends BaseListener
{
    /**
     * Returns a list of all events that will fire in the controller during its life-cycle.
     * You can override this function to add you own listener callbacks
     *
     * We attach at priority 10 so normal bound events can run before us
     *
     * @return array<string, mixed>
     */
    public function implementedEvents(): array
    {
        if (!$this->_checkRequestType('jsonapi')) {
            return [];
        }

        return [
            'Crud.beforeRender' => ['callable' => 'beforeRender', 'priority' => 75],
        ];
    }

    /**
     * Appends the pagination information to the JSON or XML output
     *
     * @param \Cake\Event\EventInterface $event Event
     * @return void
     */
    public function beforeRender(EventInterface $event): void
    {
        $viewVar = 'data';
        $action = $this->_action();

        if (method_exists($action, 'viewVar')) {
            $viewVar = $action->viewVar();
        }

        $paginatedResultset = $this
            ->_controller()
            ->viewBuilder()
            ->getVar($viewVar);

        if (!$paginatedResultset instanceof PaginatedInterface) {
            return;
        }

        $this
            ->_controller()
            ->viewBuilder()
            ->setOption('pagination', $this->_getJsonApiPaginationResponse($paginatedResultset->pagingParams()));
    }

    /**
     * Generates pagination viewVars with JSON API compatible hyperlinks.
     *
     * @param array $pagination CakePHP pagination result
     * @return array
     */
    protected function _getJsonApiPaginationResponse(array $pagination): array
    {
        $query = array_intersect_key(
            $pagination,
            [
            'sort' => null,
            'page' => null,
            'limit' => null,
            ],
            $pagination,
        );

        $request = $this->_request();
        $query += [
            'include' => $request->getQuery('include'),
            'fields' => $request->getQuery('fields'),
            'filter' => $request->getQuery('filter'),
        ];

        if ($query['sort'] === null && $request->getQuery('sort')) {
            $query['sort'] = $request->getQuery('sort');
        }

        $fullBase = (bool)$this->_controller()->Crud->getConfig('listeners.jsonApi.absoluteLinks');

        $baseUrl = $request->getAttributes()['params'];
        unset($baseUrl['pass'], $baseUrl['_matchedRoute'], $baseUrl['?']);

        $self = Router::url(
            $baseUrl + [
            '?' => ['page' => $pagination['currentPage']] + $query,
            ],
            $fullBase,
        );

        $first = Router::url(
            $baseUrl + [
            '?' => ['page' => 1] + $query,
            ],
            $fullBase,
        );

        $last = Router::url(
            $baseUrl + [
            '?' => ['page' => $pagination['pageCount']] + $query,
            ],
            $fullBase,
        );

        $prev = null;
        if ($pagination['hasPrevPage']) {
            $prev = Router::url(
                $baseUrl + [
                '?' => ['page' => $pagination['currentPage'] - 1] + $query,
                ],
                $fullBase,
            );
        }

        $next = null;
        if ($pagination['hasNextPage']) {
            $next = Router::url(
                $baseUrl + [
                '?' => ['page' => $pagination['currentPage'] + 1] + $query,
                ],
                $fullBase,
            );
        }

        return [
            'self' => $self,
            'first' => $first,
            'last' => $last,
            'prev' => $prev,
            'next' => $next,
            'record_count' => $pagination['totalCount'],
            'page_count' => $pagination['pageCount'],
            'page_limit' => $pagination['limit'],
        ];
    }
}
