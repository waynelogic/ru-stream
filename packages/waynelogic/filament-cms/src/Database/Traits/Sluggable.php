<?php namespace Waynelogic\FilamentCms\Database\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;

trait Sluggable
{
    public static function bootSluggable()
    {
        static::saving(function (Model $model) {
            if (empty($model->checkSlugs())) {
                $model->slugAttributes();
            }
        });
    }

    public function checkSlugs()
    {
        foreach ($this->slugs as $slugAttribute => $sourceAttributes) {
            if (!array_key_exists($slugAttribute, $this->attributes) || !mb_strlen($this->attributes[$slugAttribute])) {
                return false;
            }
        }
        return true;
    }


    /**
     * slugAttributes adds slug attributes to the dataset, used before saving.
     * @return void
     */
    public function slugAttributes()
    {
        foreach ($this->slugs as $slugAttribute => $sourceAttributes) {
            $this->setSluggedValue($slugAttribute, $sourceAttributes);
        }
    }

    /**
     * setSluggedValue sets a single slug attribute value, using source attributes
     * to generate the slug from and a maximum length for the slug not including
     * the counter. Source attributes support dotted notation for relations.
     * @param string $slugAttribute
     * @param mixed $sourceAttributes
     * @param int $maxLength
     * @return string
     */
    public function setSluggedValue($slugAttribute, $sourceAttributes, $maxLength = 175)
    {
        if (!array_key_exists($slugAttribute, $this->attributes) || !mb_strlen($this->attributes[$slugAttribute])) {
            if (!is_array($sourceAttributes)) {
                $sourceAttributes = [$sourceAttributes];
            }

            $slugArr = [];
            foreach ($sourceAttributes as $attribute) {
                $slugArr[] = $this->getSluggableSourceAttributeValue($attribute);
            }

            $slug = implode(' ', $slugArr);
            $slug = mb_substr($slug, 0, $maxLength);
            $slug = Str::slug($slug, $this->getSluggableSeparator(), App::getLocale());
        }
        else {
            $slug = $this->attributes[$slugAttribute] ?? '';
        }

        // Source attributes contain empty values, nothing to slug and this
        // happens when the attributes are not required by the validator
        if (!mb_strlen(trim($slug))) {
            return $this->attributes[$slugAttribute] = '';
        }

        return $this->attributes[$slugAttribute] = $this->getSluggableUniqueAttributeValue($slugAttribute, $slug);
    }

    /**
     * getSluggableUniqueAttributeValue ensures a unique attribute value, if the value is already
     * used a counter suffix is added. Returns a safe value that is unique.
     * @param string $name
     * @param mixed $value
     * @return string
     */
    protected function getSluggableUniqueAttributeValue($name, $value)
    {
        $counter = 1;
        $separator = $this->getSluggableSeparator();
        $_value = $value;

        while ($this->newSluggableQuery()->where($name, $_value)->count() > 0) {
            $counter++;
            $_value = $value . $separator . $counter;
        }

        return $_value;
    }

    /**
     * getSluggableSourceAttributeValue using dotted notation.
     * Eg: author.name
     * @return mixed
     */
    protected function getSluggableSourceAttributeValue($key)
    {
        if (strpos($key, '.') === false) {
            return $this->getAttribute($key);
        }

        $keyParts = explode('.', $key);
        $value = $this;
        foreach ($keyParts as $part) {
            if (!isset($value[$part])) {
                return null;
            }

            $value = $value[$part];
        }

        return $value;
    }

    /**
     * getSluggableSeparator is an override for the default slug separator.
     * @return string
     */
    public function getSluggableSeparator()
    {
        return defined('static::SLUG_SEPARATOR') ? static::SLUG_SEPARATOR : '-';
    }

    /**
     * newSluggableQuery returns a query that excludes the current record if it exists
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function newSluggableQuery()
    {
        $query = $this->newQuery();

        if ($this->exists) {
            $query->where($this->getKeyName(), '<>', $this->getKey());
        }

        if (in_array('Illuminate\Database\Eloquent\SoftDeletes', class_uses($this))) {
            $query->withTrashed();
        }
//        TODO Make multisite support
//        if (
//            $this->isClassInstanceOf(\October\Contracts\Database\MultisiteInterface::class) &&
//            $this->isMultisiteEnabled()
//        ) {
//            $query->withSite($this->{$this->getSiteIdColumn()});
//        }

        return $query;
    }
}
