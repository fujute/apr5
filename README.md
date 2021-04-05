# Apr5 sample
AKS, Azure File , PV,PVC, Deployment, Multi-Container, YAML Sample

## Concept:
![Azure Persistent Volume claims](https://docs.microsoft.com/en-us/azure/aks/media/concepts-storage/persistent-volume-claims.png "This is a persistent-volume-claims in AKS") </br>
ref: https://docs.microsoft.com/en-us/azure/aks/concepts-storage


## Sample:
Dynamically create and use a persistent volume with Azure Files in Azure Kubernetes Service (AKS): (ref: https://docs.microsoft.com/en-us/azure/aks/azure-files-dynamic-pv  )


## Step-by-Step
```
az aks get-credentials --admin --name MyManagedCluster --resource-group MyResourceGroup
kubectl apply -f storageclass-and-pvc.yaml
kubectl apply -f fuju-nginx-azfile.yaml

kubectl get pod

kubectl exec fuju-nginx-azfile-5c55fddc9f-6tgk  -c 1st-c -- /bin/cat /usr/share/nginx/html/index2.html
kubectl exec fuju-nginx-azfile-5c55fddc9f-6tgk6 -c 1st-c -- /bin/cat /mnt/config-1st/my-config-file.txt
kubectl exec fuju-nginx-azfile-5c55fddc9f-6tgk6 -c 2nd-c -- /bin/cat /mnt/config-2nd/my-config-file.txt
```