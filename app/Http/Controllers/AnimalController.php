<?php

namespace App\Http\Controllers;
use App\Entities\Animal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JMS;
use LaravelDoctrine\ORM\Facades\EntityManager as EM;

class AnimalController extends Controller
{
   /* CRUD Functionallity */

    /* Find a list of Animals with the provided filters */
    public function findAll(Request $request) {
        $validator = Validator::make($request->all(), [
            'orderFirst' => 'nullable|integer',
            'orderSecond' => 'nullable|integer',
            'orderThird' => 'nullable|integer',
            'hideDucks' => 'nullable',
            'hideCats' => 'nullable',
            'hideDogs' => 'nullable',
            'sortKey' => 'nullable|in:createdAt,updatedAt,name,id',
            'sortDir' => 'nullable|in:asc,desc',
        ]);

        /* If the validator fails we return a list of the validation errors*/
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()], 400);
        }

        $qb = EM::createQueryBuilder();
        $sortParams = [];
        if($request->filled('orderFirst')) {
            array_push($sortParams, $request->input('orderFirst'));
        }

        if($request->filled('orderSecond')) {
            array_push($sortParams, $request->input('orderSecond'));
        }

        if($request->filled('orderThird')) {
            array_push($sortParams, $request->input('orderThird'));
        }

        if(count($sortParams) > 0) {
            /* Implode outputs something like: foo, bar, baz */
            $qb->select("a, field(a.type, " .implode( ", ", $sortParams). ") as HIDDEN field")->from(Animal::class,'a');
            $qb->addOrderBy('field');
            $qb->where($qb->expr()->in("a.type", $sortParams));
        } else {
            $qb->select('a')->from(Animal::class,'a');
        }

        if($request->has('hideDucks')) {
            $qb->andWhere('a.type != 2');
        }

        if($request->has('hideCats')) {
            $qb->andWhere('a.type != 1');
        }

        if($request->has('hideDogs')) {
            $qb->andWhere('a.type != 0');
        }

        if($request->has('sortKey')) {
            $sortKey = $request->input('sortKey', 'createdAt');
            $sortDir = $request->input('sortDir','asc');
            $qb->addOrderBy('a.'.$sortKey,$sortDir);
        }

        $query = $qb->getQuery();
        $animals = $query->getResult();
        return response(JMS::serialize($animals), 200);
    }
    /* Find one Animal by Id*/
    public function find(Request $request) {
        /* We merge our route id on the request data */
        $request->merge(['id' => $request->route('id')]);
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer'
        ]);

        /* If the validator fails we return a list of the validation errors*/
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()], 400);
        }

        /* We search for the requested animal our database */
        $animal = EM::find(Animal::class, $request->input('id'));

        /* If the animal exists we have an instance of an Animal class */
        if ($animal instanceof Animal) {
            return response(JMS::serialize($animal), 200);
        }

        return response()->json(['error' => 'animal not found'], 400);
    }

    public function create(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:2',
            'type' => 'required|integer',
            'photo' => 'nullable|image'
        ]);

        /* If the validator fails we return a list of the validation errors*/
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()], 400);
        }

        $animal = new Animal();
        $animal->setName($request->input('name'));
        $animal->setType($request->input('type'));
        /* We persist our animal in the data base */
        EM::persist($animal);
        EM::flush();
        /* If the request had a photo we also store it on our server */
        if($request->has('photo')) {
            $this->createAnimalPhoto($request->file('photo'), $animal);
        }
        /* We return a HTTP 200 Success response with the new animal */
        return response(JMS::serialize($animal), 200);
    }

    public function update(Request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
            'name' => 'required|string|min:2',
            'type' => 'required|integer',
            'photo' => 'nullable|image'
        ]);

        /* If the validator fails we return a list of the validation errors*/
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()], 400);
        }

        /* We search for the requested animal to update on our database */
        $animal = EM::find(Animal::class, $request->input('id'));

        /* If the animal exists we have an instance of an Animal class */
        if ($animal instanceof Animal) {
            $animal->setName($request->input('name'));
            $animal->setType($request->input('type'));
            /* If the request had a photo we also store it on our server overwriting the old one if present*/
            if($request->has('photo')) {
                $this->createAnimalPhoto($request->file('photo'), $animal);
            }
            /* We merge the changes and flush them */
            EM::merge($animal);
            EM::flush();
            /* We return a HTTP 200 Success response with the updated animal */
            return response(JMS::serialize($animal), 200);
        }

        return response()->json(['error' => 'animal not found'], 400);
    }

    public function delete(Request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer'
        ]);

        /* If the validator fails we return a list of the validation errors*/
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()], 400);
        }

        /* We search for the requested animal to delete on our database */
        $animal = EM::find(Animal::class, $request->input('id'));

        /* If the animal exists we have an instance of an Animal class */
        if ($animal instanceof Animal) {
            /* First we delete the animal photo if present */
            $photo = app()->basePath('public/photos/') . $animal->getPhoto();
            if($animal->getPhoto() != null && file_exists($photo)) {
                unlink($photo);
            }
            /* We remove our animal and flush the changes */
            EM::remove($animal);
            EM::flush();
            return response()->json(['success' => '200'], 200);
        }

        return response()->json(['error' => 'animal not found'], 400);
    }

    /* */
    public function createAnimalPhoto($photo, $animal) {
        /* We set a name for our photo file, in this case its just the id and the extension */
        $newFileName = $animal->getId() . '.' .$photo->getClientOriginalExtension();
        /* We move our photo to our public/photos path*/
        $photo->move(app()->basePath('public/photos/'), $newFileName);
        /* We save the photo name on our animal entity */
        $animal->setPhoto($newFileName);
        /* We merge the changes and flush them */
        EM::merge($animal);
        EM::flush();
    }

}
