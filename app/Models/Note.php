<?php
/**
 * Note.php
 * Copyright (c) 2019 james@firefly-iii.org
 *
 * This file is part of Firefly III (https://github.com/firefly-iii).
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */
declare(strict_types=1);

namespace FireflyIII\Models;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;

/**
 * Class Note.
 *
 * @property int                                                  $id
 * @property Carbon                                               $created_at
 * @property Carbon                                               $updated_at
 * @property string                                               $text
 * @property string                                               $title
 * @property int                                                  $noteable_id
 * @property \Illuminate\Support\Carbon|null                      $deleted_at
 * @property string                                               $noteable_type
 * @property-read Collection|Note[] $noteable
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|Note newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Note newQuery()
 * @method static Builder|Note onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Note query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|Note whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Note whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Note whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Note whereNoteableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Note whereNoteableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Note whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Note whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Note whereUpdatedAt($value)
 * @method static Builder|Note withTrashed()
 * @method static Builder|Note withoutTrashed()
 * @mixin Eloquent
 */
class Note extends Model
{
    use SoftDeletes;
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts
        = [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    /** @var array Fields that can be filled */
    protected $fillable = ['title', 'text', 'noteable_id', 'noteable_type'];

    /**
     * @param string|null $value
     *
     * @return string|null
     */
    public function getTextAttribute(?string $value): ?string
    {
        return null === $value ? null : htmlspecialchars_decode($value, ENT_QUOTES);
    }

    /**
     * @codeCoverageIgnore
     *
     * Get all of the owning noteable models.
     */
    public function noteable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * @param $value
     *
     * @codeCoverageIgnore
     */
    public function setTextAttribute(string $value): void
    {
        $this->attributes['text'] = e($value);
    }
}
