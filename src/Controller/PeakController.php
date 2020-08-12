<?php

namespace App\Controller;

use App\Entity\Peak;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;


class PeakController extends AbstractController
{
    /**
     * @Route("/api/peak/create", methods={"PUT"})
     * @SWG\Parameter(name="name", in="formData", type="string", description="The name of the new peak", required=true)
     * @SWG\Parameter(name="lat", in="formData", type="number", description="The latitude of the new peak", required=true)
     * @SWG\Parameter(name="lon", in="formData", type="number", description="The longitude of the new peak", required=true)
     * @SWG\Parameter(name="alt", in="formData", type="number", description="The altitude of the new peak", required=true)
     * @SWG\Response(response=200, @Model(type=Peak::class), description="The newly created peak")
     */
    public function createPeak(Request $request)
    {
        $name = $request->request->get("name");
        $lat = $request->request->get("lat");
        $lon = $request->request->get("lon");
        $alt = $request->request->get("alt");

        $peak = new Peak();
        $peak->setName($name);
        $peak->setLat($lat);
        $peak->setLon($lon);
        $peak->setAlt($alt);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($peak);
        $entityManager->flush();

        $encoders = array(new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());
        $serializer = new Serializer($normalizers, $encoders);
        $peakSerialized = $serializer->serialize($peak, 'json');
        return new Response($peakSerialized);
    }
    
    /**
     * @Route("/api/peak/read/{id}", methods={"GET"})
     * @SWG\Parameter(name="id", in="path", type="integer", description="The id of the requested peak", required=true)
     * @SWG\Response(response=200, @Model(type=Peak::class), description="The requested peak")
     * @SWG\Response(response=404, description="Peak not found")
     */
    public function getPeak(int $id)
    {
        $peak = $this->getDoctrine()->getRepository(Peak::class)->find($id);
        if (!$peak) throw $this->createNotFoundException("The peak does not exist");

        $encoders = array(new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());
        $serializer = new Serializer($normalizers, $encoders);
        $peakSerialized = $serializer->serialize($peak, 'json');
        return new Response($peakSerialized);
    }
    
    /**
     * @Route("/api/peak/get/{id}", methods={"POST"})
     * @SWG\Parameter(name="id", in="path", type="integer", description="The id of the requested peak", required=true)
     * @SWG\Parameter(name="name", in="formData", type="string", description="The new name of the peak")
     * @SWG\Parameter(name="lat", in="formData", type="number", description="The new latitude of the peak")
     * @SWG\Parameter(name="lon", in="formData", type="number", description="The new longitude of the peak")
     * @SWG\Parameter(name="alt", in="formData", type="number", description="The new altitude of the peak")
     * @SWG\Response(response=200, @Model(type=Peak::class), description="The modified peak")
     * @SWG\Response(response=404, description="Peak not found")
     */
    public function updatePeak(int $id, Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $peak = $entityManager->getRepository(Peak::class)->find($id);
        if (!$peak) throw $this->createNotFoundException("The peak does not exist");
        
        $name = $request->request->get("name");
        $lat = $request->request->get("lat");
        $lon = $request->request->get("lon");
        $alt = $request->request->get("alt");

        if ($name) $peak->setName($name);
        if ($lat) $peak->setLat($lat);
        if ($lon) $peak->setLon($lon);
        if ($alt) $peak->setAlt($alt);
        
        $entityManager->flush();

        $encoders = array(new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());
        $serializer = new Serializer($normalizers, $encoders);
        $peakSerialized = $serializer->serialize($peak, 'json');
        return new Response($peakSerialized);
    }
    
    /**
     * @Route("/api/peak/delete/{id}", methods={"DELETE"})
     * @SWG\Parameter(name="id", in="path", type="integer", description="The id of the requested peak", required=true)
     * @SWG\Response(response=200, description="Peak successfully deleted")
     * @SWG\Response(response=404, description="Peak not found")
     */
    public function deletePeak(int $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $peak = $entityManager->getRepository(Peak::class)->find($id);
        if (!$peak) throw $this->createNotFoundException("The peak does not exist");
        
        $entityManager->remove($peak);
        $entityManager->flush();
        return new Response();
    }

    /**
     * @Route("/api/peak/get-in-zone", methods={"GET"})
     * @SWG\Parameter(name="n", in="query", type="number", description="The northbound latitude of the boundary box", required=true)
     * @SWG\Parameter(name="w", in="query", type="number", description="The westbound longitude of the boundary box", required=true)
     * @SWG\Parameter(name="s", in="query", type="number", description="The southbound latitude of the boundary box", required=true)
     * @SWG\Parameter(name="e", in="query", type="number", description="The eastbound longitude of the boundary box", required=true)
     * @SWG\Response(response=200, @SWG\Schema(type="array", @SWG\Items(ref=@Model(type=Peak::class))),
     *               description="The peaks inside the boundary box")
     */
    public function getPeaksInZone(Request $request) {
        $northboundLat = (float) $request->query->get("n");
        $westboundLon = (float) $request->query->get("w");
        $southboundLat = (float) $request->query->get("s");
        $eastboundLon = (float) $request->query->get("e");

        $peaks = $this->getDoctrine()->getRepository(Peak::class)
            ->findByBoundaryBox($northboundLat, $westboundLon, $southboundLat, $eastboundLon);

        $encoders = array(new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());
        $serializer = new Serializer($normalizers, $encoders);
        $peaksSerialized = $serializer->serialize($peaks, 'json');
        return new Response($peaksSerialized);
    }
}
