<?php

namespace App\Repository\Interfaces;

interface IBaseRepository
{
    /**
     * Get model instance.
     */
    public function model();

    /**
     * Get all models.
     *
     * @param array $columns
     * @param array $relations
     */
    public function all(array $columns = ['*'], array $relations = []);

    /**
     * Get all trashed models.
     *
     * @return Collection
     */
    public function allTrashed();

    /**
     * Find model by id.
     *
     * @param int $modelId
     * @param array $columns
     * @param array $relations
     * @param array $appends
     * @return Model
     */
    public function findById(
        int $modelId,
        array $columns = ['*'],
        array $relations = [],
        array $appends = []
    );

    /**
     * Find trashed model by id.
     *
     * @param int $modelId
     * @return Model
     */
    public function findTrashedById(int $modelId);

    /**
     * Find only trashed model by id.
     *
     * @param int $modelId
     * @return Model
     */
    public function findOnlyTrashedById(int $modelId);

    /**
     * Create a model.
     *
     * @param array $payload
     * @return Model
     */
    public function create(array $payload);

    /**
     * Update existing model.
     *
     * @param int $modelId
     * @param array $payload
     * @return bool
     */
    public function update(int $modelId, array $payload);

    /**
     * Delete model by id.
     *
     * @param int $modelId
     * @return bool
     */
    public function deleteById(int $modelId): bool;

    /**
     * Restore model by id.
     *
     * @param int $modelId
     * @return bool
     */
    public function restoreById(int $modelId): bool;

    /**
     * Permanently delete model by id.
     *
     * @param int $modelId
     * @return bool
     */
    public function permanentlyDeleteById(int $modelId): bool;

    /**
     * Check existis.
     *
     * @return bool
     */
    public function checkExists(string $columns, $value): bool;
}
