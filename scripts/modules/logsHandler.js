function Log(type, data) {
   const _type = type;
   const _data = data;
   const _timestamp = Date.now();
   const fullData = {
      type: _type,
      timestamp: new Date(_timestamp),
      data: _data,
   };
   
   this.getType = () => _type;
   this.getData= () => _data;
   this.getTimestamp = () => _timestamp;
   this.getLog = () => fullData;
}
