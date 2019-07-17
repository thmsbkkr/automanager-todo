import React, { Component } from 'react';

export default class TaskInput extends Component {
  constructor (props) {
    super (props)
  }

  render() {
    return (
      <div className="card">
        <div className="card-body">
          <input className="form-control"></input>
        </div>
      </div>
    );
  }
}
