# Apr5 sample
AKS, Azure File , PV,PVC, Deployment, Multi-Container, YAML Sample

## Concept:
![Azure Persistent Volume claims](https://docs.microsoft.com/en-us/azure/aks/media/concepts-storage/persistent-volume-claims.png "This is a persistent-volume-claims in AKS") </br>
ref: https://docs.microsoft.com/en-us/azure/aks/concepts-storage


## A persistent volume can be used by one or many pods, and can be dynamically or statically provisioned
### Dynamically create and use a persistent volume with Azure Files in Azure Kubernetes Service (AKS):
>" How to dynamically create an Azure Files share for use by multiple pods in an Azure Kubernetes Service (AKS) cluster "
>
 (Ref: https://docs.microsoft.com/en-us/azure/aks/azure-files-dynamic-pv )

### Step-by-Step
```
az aks get-credentials --admin --name MyManagedCluster --resource-group MyResourceGroup
kubectl apply -f storageclass-and-pvc.yaml
kubectl apply -f fuju-nginx-azfile.yaml

kubectl get pod

kubectl exec fuju-nginx-azfile-5c55fddc9f-6tgk  -c 1st-c -- /bin/cat /usr/share/nginx/html/index2.html
kubectl exec fuju-nginx-azfile-5c55fddc9f-6tgk6 -c 1st-c -- /bin/cat /mnt/config-1st/my-config-file.txt
kubectl exec fuju-nginx-azfile-5c55fddc9f-6tgk6 -c 2nd-c -- /bin/cat /mnt/config-2nd/my-config-file.txt
```

### Manually create and use a volume with Azure Files share in Azure Kubernetes Service (AKS):
>" Container-based applications often need to access and persist data in an external data volume. " 
>
(Ref: https://docs.microsoft.com/en-us/azure/aks/azure-files-volume )

### Step-by-Step
```
kubectl apply -f azurefile-mount-options-pv.yaml --namespace ratingsapp
kubectl apply -f azurefile-mount-options-pvc.yaml --namespace ratingsapp
kubectl apply -f fuju-nginx-azfile-deployment.yaml --namespace ratingsapp

kubectl exec fuju-nginx-azfile-s1-789887b6cc-p9fnb -c 1st-c -n ratingsapp -- /bin/cat /usr/share/nginx/html/dateoutput.txt
kubectl exec fuju-nginx-azfile-s1-789887b6cc-p9fnb -c 2nd-c -n ratingsapp -- /bin/cat /mnt/html/dateoutput.txt
```

## See Also:
Transfer data with AzCopy and file storage : 
https://docs.microsoft.com/en-us/azure/storage/common/storage-use-azcopy-files

