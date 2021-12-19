function Log(type, data) {
   const _type = type;
   const _data = data;
   const _timestamp = Date.now();
   const _fullData = {
      type: _type,
      timestamp: _timestamp,
      data: _data,
   };
   
   this.getType = () => _type;
   this.getData= () => _data;
   this.getFullData = () => _fullData;
   this.getTimestamp = () => _timestamp;
}
